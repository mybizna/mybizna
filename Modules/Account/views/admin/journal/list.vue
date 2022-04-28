<template>
    <div class="journals">
        <journal-modal :entry_id="journal_id" v-if="journalModal" />

        <h2 class="add-new-journal">
            <span>{{ this.$func.__("Journals", "erp") }}</span>
            <a
                href="#"
                class="erp-journal-new"
                @click.prevent="$router.push({ name: 'JournalCreate' })"
            >
                {{ this.$func.__("New Journal Entry", "erp") }}
            </a>
        </h2>

        <list-table
            tableClass="wp-ListTable widefat fixed journal-list"
            action-column="actions"
            :columns="columns"
            :rows="row_data"
            :total-items="paginationData.totalItems"
            :total-pages="paginationData.totalPages"
            :per-page="paginationData.perPage"
            :current-page="paginationData.currentPage"
            :showCb="false"
            @pagination="goToPage"
        >
            <template slot="l_id" slot-scope="data">
                <strong>
                    <router-link
                        :to="{
                            name: 'JournalSingle',
                            params: { id: data.row.l_id },
                        }"
                    >
                        #{{ data.row.l_id }}
                    </router-link>
                </strong>
            </template>
        </list-table>
    </div>
</template>

<script>
import ListTable from "assets/components/list-table/ListTable.vue";

export default {
    components: {
        ListTable,
    },

    data() {
        return {
            journalModal: false,
            columns: {
                l_id: { label: this.$func.__("Voucher No.", "erp") },
                l_date: { label: this.$func.__("Date", "erp") },
                l_particulars: { label: this.$func.__("Particulars", "erp") },
                amount: { label: this.$func.__("Amount", "erp") },
            },
            rows: [],
            paginationData: {
                totalItems: 0,
                totalPages: 0,
                perPage: 20,
                currentPage:
                    this.$route.params.page === undefined
                        ? 1
                        : parseInt(this.$route.params.page),
            },
            journal_id: 0,
        };
    },
    created() {
        this.fetchItems();
    },

    computed: {
        row_data() {
            const items = this.rows;
            items.map((item) => {
                item.l_id = item.voucher_no;
                item.l_date = this.formatDate(item.trn_date);
                item.l_particulars = item.particulars;
                item.amount = item.total;
            });
            return items;
        },
    },

    methods: {
        fetchItems() {
            this.rows = [];
            window.axios
                .get("/journals", {
                    params: {
                        per_page: this.paginationData.perPage,
                        page:
                            this.$route.params.page === undefined
                                ? this.paginationData.currentPage
                                : this.$route.params.page,
                    },
                })
                .then((response) => {
                    this.rows = response.data;
                    this.paginationData.totalItems = parseInt(
                        response.headers["x-wp-total"]
                    );
                    this.paginationData.totalPages = parseInt(
                        response.headers["x-wp-totalpages"]
                    );

                })
                .catch((error) => {
                    throw error;
                });
        },

        goToPage(page) {
            const queries = Object.assign({}, this.$route.query);
            this.paginationData.currentPage = page;
            this.$router.push({
                name: "PaginateJournals",
                params: { page: page },
                query: queries,
            });

            this.fetchItems();
        },
    },
};
</script>
<style>
.journals .add-new-journal {
    margin-top: 15px;
    align-items: center;
    display: flex;
}
.journals .add-new-journal span {
    font-size: 18px;
    font-weight: bold;
}
.journals .add-new-journal a {
    background: #1a9ed4;
    border-radius: 3px;
    color: #fff;
    font-size: 12px;
    height: 29px;
    line-height: 29px;
    margin-left: 13px;
    text-align: center;
    text-decoration: none;
    width: 135px;
}

.journals .journal-list {
    border-radius: 3px;
}

.journals .journal-list tbody {
    background: #fafafa;
}
.journals .journal-list th ul,
.journals .journal-list th li {
    margin: 0;
}
.journals .journal-list th li {
    display: flex;
    align-items: center;
}

.journals .journal-list th li img {
    width: 22px;
    padding-right: 5px;
}

.journals .journal-list .column.title .selected {
    color: #1a9ed4;
}
.journals .journal-list .column.title a {
    color: #222;
    font-weight: normal;
}

.journals .journal-list .column.title a:hover {
    color: #1a9ed4;
}

.journals .journal-list .check-column input {
    border-color: #e7e7e7;
    box-shadow: none;
    border-radius: 3px;
}

.journals .journal-list .check-column input:checked {
    background: #1abc9c;
    border-color: #1abc9c;
    border-radius: 3px;
}
.journals .journal-list .check-column input :before {
    color: #fff;
}

.journals .journal-list .row-actions {
    padding-left: 20px;
}
.journals .widefat tfoot td,
.journals .widefat tbody th {
    line-height: 2.5em;
}
.journals .widefat tbody td {
    line-height: 3em;
}
</style>
