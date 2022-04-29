<template>
    <div class="tax-section">
        <div class="sectionHeader">{{ this.$func.__('Tax Shortcuts', 'erp') }}</div>
        <ul>
            <li><router-link :to="{ name: 'TaxZones' }">{{ this.$func.__('View Tax Zones', 'erp') }}</router-link></li>
            <li><router-link :to="{ name: 'TaxCategories' }">{{ this.$func.__('View Tax Categories', 'erp') }}</router-link></li>
            <li><router-link :to="{ name: 'TaxAgencies' }">{{ this.$func.__('View Tax Agencies', 'erp') }}</router-link></li>
            <li><a href="https://mybizna.com/docs/accounting/tax/" target="_blank">{{ this.$func.__('Tax Help', 'erp') }}</a></li>
        </ul>
    </div>
</template>

<script>
export default {
};
</script>

<style scoped>
    .sectionHeader {
        font-weight: bold;
        margin-bottom: 10px;
    }
    .tax-section {
        width: 240px;
        border: solid 1px #d9eaf9;
        background-color: #edf4fb;
        padding: 20px 25px;
        border-radius: 4px;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        margin-bottom: 30px;
        margin-top: 40px;
    }
</style>
