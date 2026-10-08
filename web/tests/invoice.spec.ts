import { describe, it, expect } from 'vitest'
import type { Invoice } from '../types/invoice'

describe('Invoice types', () => {
  it('should accept a valid invoice status', () => {
    const status: Invoice['status'] = 'received'
    expect(['received', 'validating', 'valid', 'invalid', 'forwarded', 'archived']).toContain(status)
  })

  it('should accept a valid invoice format', () => {
    const format: Invoice['format'] = 'xrechnung-ubl'
    expect(['xrechnung-ubl', 'xrechnung-cii', 'zugferd-basic', 'zugferd-comfort', 'zugferd-extended']).toContain(format)
  })
})
