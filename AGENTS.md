# Rechnungspost — Agent & Contributor Conventions

## Architecture Decisions (binding)

### Repository
- Monorepo: `/api` (Laravel 11, PHP 8.3), `/web` (Nuxt 3, Vue 3, TypeScript)
- Deploy: `/deploy` Helm chart, GitOps in `pixelandprocess-gitops`

### Stack
| Layer | Technology |
|---|---|
| API | Laravel 11, PHP 8.3, PostgreSQL, Redis |
| Frontend | Nuxt 3, Vue 3, TypeScript, Tailwind CSS |
| Auth | Laravel Sanctum (API tokens for SPA) |
| Storage | S3-compatible (MinIO dev, AWS S3/compatible prod) |
| Queue | Redis + Laravel Horizon |
| Email inbound | Postmark webhooks, `{slug}@in.rechnungspost.de` |
| Invoice parsing | `horstoeko/zugferd` PHP library |
| PDF rendering | `spatie/browsershot` |
| Billing | Stripe Checkout + SEPA |
| Monitoring | Sentry |

### Database
- Single PostgreSQL database, `company_id` FK on all tenant-scoped tables
- No schema-per-tenant
- Multi-tenancy via `BelongsToCompany` Eloquent trait + global scope (see `app/Traits/BelongsToCompany.php`)

### Email inbound
- Postmark inbound webhook
- Domain: `in.rechnungspost.de`
- Per-company address: `{slug}@in.rechnungspost.de`

### Invoice DTO (canonical JSON, shared parser->validator->connectors->dashboard)
```json
{
  "invoice_number": "RE-2024-0001",
  "date": "2024-01-15",
  "due_date": "2024-02-15",
  "sender": {
    "name": "Lieferant GmbH",
    "vat_id": "DE123456789",
    "address": { "street": "Musterstr. 1", "city": "Berlin", "zip": "10115", "country": "DE" }
  },
  "recipient": { "...same shape as sender..." },
  "lines": [{ "description": "...", "quantity": 1, "unit_price": 100, "vat_rate": 19, "line_total": 100 }],
  "amount_net": 100.00,
  "vat_amount": 19.00,
  "amount_gross": 119.00,
  "currency": "EUR",
  "format": "xrechnung-ubl",
  "payment_terms": "30 days",
  "bank_details": { "iban": "DE89...", "bic": "DEUTDEDB" }
}
```

### Validation report
```json
{ "valid": true, "profile": "xrechnung-ubl", "errors": [] }
```
Error shape: `{ "rule_id": "BR-01", "severity": "error|warning", "message": "...", "xpath": "..." }`

### Storage paths
S3/MinIO: `/{company_id}/invoices/{YYYY}/{invoice_id}/`

### Billing plans
| Plan | Price | Limit |
|---|---|---|
| Free | €0 | 5 invoices/month |
| Starter | €19/mo | 50 invoices/month |
| Business | €49/mo | Unlimited |
| Steuerberater | €149/mo | 20 mandates |

## Coding Rules

### General
- Never commit `.env` or secrets — use `.env.example` only
- Files under 500 lines; split large files
- Conventional Commits: `feat(api):`, `fix(web):`, `chore(deploy):` etc.

### Laravel `/api`
- PHP 8.3+; add `declare(strict_types=1);` on all new files
- PSR-12 style enforced by Laravel Pint (`vendor/bin/pint --test`)
- PHPStan level 5 must pass (`vendor/bin/phpstan analyse`)
- Use Form Request validation, API Resources, Repository pattern for complex queries
- Apply `BelongsToCompany` trait on all tenant-scoped models
- Migrations: never edit existing migrations after merging to main
- Always add `company_id` index on tenant-scoped tables
- PHPUnit tests: `vendor/bin/phpunit`

### Nuxt `/web`
- TypeScript strict mode — no `any`
- Components: PascalCase. Composables: `useXxx`. Types in `~/types/`
- No inline styles — Tailwind only
- ESLint must pass with zero warnings

### CI — all 5 jobs must be green before review
- `api-lint` — Pint + PHPStan
- `api-test` — PHPUnit
- `web-lint` — ESLint
- `web-test` — Vitest
- `web-build` — Nuxt build

## Git Workflow (Hermes worktrees)
```bash
# Create worktree for a task
git worktree add .worktrees/<task-id> -b hermes/<task-id>-<slug>
cd .worktrees/<task-id>

# Commit & push
git add -p
git commit -m "feat(api): ..."
git push -u origin hermes/<task-id>-<slug>
gh pr create --fill --label hermes
```

## K8s / Helm
- Never `kubectl apply` on prod — open a PR against `pixelandprocess-gitops`
- Helm chart in `/deploy/rechnungspost/`
- Namespace: `rechnungspost`
- Always run `helm template ./deploy/rechnungspost` to validate manifests before committing

## Local Dev
```bash
docker-compose up -d          # starts api, postgres, redis, minio, mailpit
docker-compose exec api php artisan migrate
docker-compose exec api php artisan db:seed
# Frontend:
cd web && npm install && npm run dev
# Mailpit UI: http://localhost:8025
# MinIO console: http://localhost:9001 (minioadmin / minioadmin)
```
