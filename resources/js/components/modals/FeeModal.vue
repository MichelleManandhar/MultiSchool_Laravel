<template>
    <modal name="feeModal" width="60%" height="60%">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-text">Fee Category list</div>
                <div class="add-button">
                    <button @click="addExam()">Add Fee Category</button>
                </div>
            </div>
            <ag-grid-vue
                    class="ag-theme-blue"
                    :columnDefs="columnDefs"
                    :rowData="rowData"
                    @grid-ready="onGridReady"
                    rowSelection="multiple"
                    style="overflow:'scroll'"
                    :editType="editType"
                    @rowValueChanged="rowValueChanged"
            ></ag-grid-vue>
        </div>
    </modal>
</template>

<script>
    import { AgGridVue } from "ag-grid-vue";
    import axios from "axios";
    export default {
        name: "Fee",
        components: {
            "ag-grid-vue": AgGridVue
        },
        data() {
            return { isActive: false, columnDefs: null, rowData: null, editType: null };
        },
        beforeMount() {
            this.columnDefs = [
                {
                    headerName: "S.N",
                    cellRenderer : function (params) {
                        return params.node.id ;
                    },
                    sortable: true,
                    filter: true,
                    width: 200
                },
                {
                    headerName: "Fee Category",
                    field: "name",
                    sortable: true,
                    filter: true,
                    editable: true,
                    width: 200
                },{
                    headerName: "Description",
                    field: "description",
                    sortable: true,
                    filter: true,
                    editable: true,
                    width: 200
                },
];
            this.editType = "fullRow";

            this.getFeeCategoryData();
        },
        methods: {
            getFeeCategoryData() {
                this.loader = true;
                axios.get("/feeCategory").then(res => {
                    this.loader = false;
                    this.rowData = res.data.feeCategories;
                });
            },
            addExam() {
                this.gridApi.updateRowData({ add: [{}] });
            },
            onGridReady(params) {
                this.gridApi = params.api;
                this.columnApi = params.columnApi;
            },

            rowValueChanged(event) {
                if (event.data.id != null) {
                    axios
                        .post(`/feeCategory/edit/${event.data.id}`, {
                            name: event.data.name,
                            description: event.data.description,
                        })
                        .then(res => {
                            eventBus.$emit('update-fee-cat');
                            this.$noty.success("Fee description is  edited");
                        });
                } else {
                    axios
                        .post("/feeCategory/store", {
                            name: event.data.name,
                            description: event.data.description,
                        })
                        .then(res => {
                            eventBus.$emit('update-fee-cat');
                            event.node.setData(res.data.exam);
                            this.$noty.success("Fee description is stored");
                        });
                }
            }
        }
    }

</script>

<style scoped lang = "scss">
    .ag-theme-blue {
        display: flex;
        width: 60%;
        height: 30vh;
        margin-left: 30px;
        margin-top: 30px;
    }
    .modal-content {
        height: 100%;
        width: 100%;
        padding: 10px;
        .modal-header {
            font-size: 20px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
        }
        button {
            background-color: rgb(0, 136, 199);
            color: white;
            padding: 10px;
            box-sizing: border-box;
        }
    }
    .loader {
        position: absolute;
        background: rgba(0, 0, 0, 0.5);
        height: 100vh;
        width: 100%;
        z-index: 999;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .loader loader-item {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .loader i {
        font-size: 10vh;
        color: white;
    }
    .loader span {
        font-size: 24px;
        color: white;
    }
</style>