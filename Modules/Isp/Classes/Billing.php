<?php


class Billing extends Model
{
    public function  generate_invoice( billing)
{
invoice_line_ids = []

items = self.env['mybizna.isp.billing_items'].search([("billing_id.id", "=", billing.id)])

for item in items:

    invoice_line_ids.append((0, 0, {
            'name': item.title,
            'quantity': 1,
            'price_unit': item.amount,
            'price_subtotal' : item.amount,
            'account_id': 21,
    }))

invoice = self.env['account.move'].create({
    'move_type': 'out_invoice',
    'partner_id': billing.connection_id.partner_id.id,
    'user_id': self.env.user.id,
    'invoice_line_ids': invoice_line_ids,
})


invoice.action_post()

self.reconcile_invoice(invoice)
}


public function reconcile_invoice(invoice){

if invoice.state != 'posted' \
        or invoice.payment_state not in ('not_paid', 'partial') \
        or not invoice.is_invoice(include_receipts=True):
    return False

pay_term_lines = invoice.line_ids\
    .filtered(lambda line: line.account_id.user_type_id.type in ('receivable', 'payable'))

domain = [
    ('account_id', 'in', pay_term_lines.account_id.ids),
    ('move_id.state', '=', 'posted'),
    ('partner_id', '=', invoice.commercial_partner_id.id),
    ('reconciled', '=', False),
    '|', ('amount_residual', '!=',
          0.0), ('amount_residual_currency', '!=', 0.0),
]

if invoice.is_inbound():
    domain.append(('balance', '<', 0.0))
else:
    domain.append(('balance', '>', 0.0))

for line in self.env['account.move.line'].search(domain):

    lines = self.env['account.move.line'].browse(line.id)
    lines += invoice.line_ids.filtered(
        lambda line: line.account_id == lines[0].account_id and not line.reconciled)
    lines.reconcile()
    }
    public function  processBilling(self){

billings = self.env['mybizna.isp.billing'].search([
        ("is_paid", "=", True),
        ("invoice_id.payment_state", "=", 'paid'),
])

for billing in billings:
    billing.write({'is_paid':True})
    billing.connection_id.write({
        'is_paid':True
    })

    self.env.cr.commit()

    billing.connection_id.addToRadius(billing.connection_id.id)

}
}
