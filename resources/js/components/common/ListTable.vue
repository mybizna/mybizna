<template>
    <!-- generate sample code -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th v-for="column in columns" :key="column.name">
                        {{ column.label }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in rows" :key="row.id">
                    <td v-for="column in columns" :key="column.name">
                        {{ row[column.name] }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
// generate sample code
export default {
    data: function () {
        return {
            columns: [
                { name: 'id', label: 'ID' },
                { name: 'name', label: 'Name' },
                { name: 'email', label: 'Email' },
                { name: 'created_at', label: 'Created At' },
                { name: 'updated_at', label: 'Updated At' }
            ],
            rows: [
                { id: 1, name: 'John Doe', email: 'johdoe@johndoe.com', created_at: '2019-01-01', updated_at: '2019-01-01' },
                { id: 1, name: 'John Doe', email: 'johdoe@johndoe.com', created_at: '2019-01-01', updated_at: '2019-01-01' },
            ]
        }
    }
};
</script>