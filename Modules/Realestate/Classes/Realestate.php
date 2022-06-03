<?php

use Illuminate\Support\Facades\DB;


use Modules\Account\Classes\Invoices;

class Realestate{
    def generate_units(self):

    for item in range(self.generator_total):

        house_name = self.generator_prefix + str(item + 1)

        items = self.env['mybizna.realestate.unit'].search(
            [("title", "=", house_name)])

        setups = self.env['mybizna.realestate.building_unit_setup'].search(
            [("building_id.id", "=", self.id)])

        if not len(items):
            res = self.env['mybizna.realestate.unit'].create(
                {
                    'title': house_name,
                    'building_id': self.id,
                    'currency_id': self.currency_id.id,
                    'amount': self.generator_amount,
                    'type': self.generator_type,
                    'deposit': self.generator_deposit,
                    'goodwill': self.generator_goodwill,
                    'rooms': self.generator_rooms,
                    'bathrooms': self.generator_bathrooms,
                }
            )
            self.env.cr.commit()

            for setup in setups:

                objects = {
                    'title': setup.title,
                    'unit_id': res.id,
                    'currency_id': setup.currency_id.id,
                    'amount': setup.amount,
                }

                self.env['mybizna.realestate.unit_setup'].create(
                    objects)
            self.env.cr.commit()

    return self.write({'has_units': True})

def auto_fill(self):

    params = self.env['ir.config_parameter'].sudo()

    currency_id = params.get_param('mybizna_mpesa_currency_id')

    self.env['mybizna.realestate.building_unit_setup'].create(
        {'title': "Garbage Collection", 'building_id': self.id,
            'currency_id': currency_id, 'amount': 100}
    )
    self.env['mybizna.realestate.building_unit_setup'].create(
        {'title': "Internet", 'building_id': self.id,
            'currency_id': currency_id, 'amount': 500}
    )

    self.env['mybizna.realestate.building_unit_setup'].create(
        {'title': "Security", 'building_id': self.id,
            'currency_id': currency_id, 'amount': 500}
    )

    return self.write({'is_filled': True})


    def auto_fill(self):

    params = self.env['ir.config_parameter'].sudo()

    currency_id = params.get_param('mybizna_mpesa_currency_id')

    self.env['mybizna.realestate.unit_setup'].create(
        {'title': "Garbage Collection", 'building_id': self.id,
            'currency_id': currency_id, 'amount': 100}
    )
    self.env['mybizna.realestate.unit_setup'].create(
        {'title': "Internet", 'building_id': self.id,
            'currency_id': currency_id, 'amount': 500}
    )

    self.env['mybizna.realestate.unit_setup'].create(
        {'title': "Security", 'building_id': self.id,
            'currency_id': currency_id, 'amount': 500}
    )

    return self.write({'is_filled': True})

}