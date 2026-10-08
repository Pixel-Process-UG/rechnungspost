export type InvoiceFormat =
  | 'xrechnung-ubl'
  | 'xrechnung-cii'
  | 'zugferd-basic'
  | 'zugferd-comfort'
  | 'zugferd-extended'

export type InvoiceStatus =
  | 'received'
  | 'validating'
  | 'valid'
  | 'invalid'
  | 'forwarded'
  | 'archived'

export interface InvoiceSender {
  name: string
  vat_id?: string
  address?: {
    street?: string
    city?: string
    zip?: string
    country?: string
  }
}

export interface InvoiceLine {
  description: string
  quantity: number
  unit_price: number
  vat_rate: number
  line_total: number
}

export interface InvoiceDto {
  invoice_number: string
  date: string
  due_date: string
  sender: InvoiceSender
  recipient?: InvoiceSender
  lines: InvoiceLine[]
  amount_net: number
  vat_amount: number
  amount_gross: number
  currency: string
  format: InvoiceFormat
  payment_terms?: string
  bank_details?: {
    iban?: string
    bic?: string
  }
}

export interface ValidationReport {
  valid: boolean
  profile: string
  errors: Array<{
    rule_id: string
    severity: 'error' | 'warning'
    message: string
    xpath?: string
  }>
}

export interface Invoice {
  id: number
  company_id: number
  sender_name: string | null
  sender_vat_id: string | null
  invoice_number: string | null
  date: string | null
  due_date: string | null
  amount_net: string | null
  amount_gross: string | null
  vat_amount: string | null
  currency: string
  format: InvoiceFormat
  status: InvoiceStatus
  parsed_dto: InvoiceDto | null
  validation_report: ValidationReport | null
  received_at: string | null
  created_at: string
  updated_at: string
}
