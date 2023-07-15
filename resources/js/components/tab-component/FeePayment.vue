<template>
    <div class="dashbody" v-show="this.isActiveComputed">
        {{year}} /{{month}}
        <ag-grid-vue
                style="overflow:scroll;height:70%"
                class="ag-theme-blue"
                :getRowStyle="getRowStyle"
                :columnDefs="columnDefs"
                :rowData="rowData"
                @grid-ready="onGridReady"
                @rowValueChanged="rowValueChanged"
                @rowSelected="rowSelected"
                :editType="editType"
                rowSelection="multiple"
                :pinnedTopRowData="pinnedTopRowData"
                :enterMovesDownAfterEdit="true"
                :enterMovesDown="true"
                :groupUseEntireRow="false"
                :rowClassRules="rowClassRules"
                :gridOptions="gridOptions"
        ></ag-grid-vue>
    </div>
</template>

<script>
    import axios from "axios";
    import { AgGridVue } from "ag-grid-vue";
    import Loader from "../modals/Loader";
    var today = new Date();
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    export default {
        name: "FeePayment",
        props: {
            name: { required: true },
            isselected: { default: false },
            classId: { required: true },
            sectionId: { required: true }
        },
        data() {
            return {
                month : mm,
                year : yyyy,
                isActive: false,
                columnDefs: null,
                rowData: [],
                editType: null,
                loadingCellRenderer: null,
                loadingCellRendererParams: null,
                feeCategory: [],
                loader: false,
                pinnedTopRowData: null,
                classname: this.$route.params.classname,
                sectionname: this.$route.params.sectionname,
                rowClassRules: null,
                gridOptions: null,
                // overlayNoRowsTemplate: `<h3>Please select Month</h3>`
            };
        },
        watch: {
            sectionId: function() {
                this.feeData();
            }
        },
        computed: {
            href() {
                return "#" + this.name.toLowerCase().replace(/ /g, "-");
            },
            isActiveComputed() {
                return this.isActive;
            }
        },

        async mounted() {
            this.isActive = this.isselected;
            this.getFeeCategoryData();
            this.feeData();
            eventBus.$on('update-student' , this.feeData)
            eventBus.$on('bill-changed' , this.feeData)
        },
        async beforeMount(){
            this.gridOptions = {};
            this.rowData = [];
        },
        methods: {
            getRowStyle(params) {
                return {
                    // backgroundColor: "green"
                };
            },
            rowValueChanged: async function(event) {
                this.updateFeeForStudents(event);
                return;

            },
            rowSelected() {},
            redrawRow(i) {
                var row = this.gridApi.getDisplayedRowAtIndex(i);

                this.gridApi.redrawRows({ rowNodes: [row] });
            },


            onGridReady(params) {
                this.gridApi = params.api;
                this.columnApi = params.columnApi;
            },



            async updateFeeForStudents(event) {
                console.log(event);
                let response = await axios.post(
                    `/fee/storepayment/${this.sectionId}/${event.data.id}`,
                    event.data
                )
                if(response.data.status === 1){
                    this.$noty.success(response.data.message);
                    this.feeData();
                }
            },

            async feeData(){
                this.loader = true;
                axios.get(`/fee/payment/${this.sectionId}`)
                    .then(res => {
                        this.loader = false;
                        this.rowData = res.data;
                        this.gridApi.hideOverlay();
                        eventBus.$emit('payment-update');
                    })
                    .catch(async e => {
                        this.rowData = [];
                        this.$noty.error("Error while loading data from the server");
                    });
            },
            async getFeeCategoryData() {
                this.columnDefs = [
                    {
                        headerName: "Student id",
                        field: "id",
                        hide: true,
                    },
                    {
                        headerName: "Roll",
                        field: "roll_no",
                        width: 50,
                        sortable: true,
                    },
                    {
                        headerName: "Student Name",
                        field: "name",
                        sortable: true,
                        filter: true,
                    }, {
                        headerName: "Total Payable Fee",
                        field: "total_payable",
                        sortable: true,
                        filter: true,
                        editable: false,
                    },
                    {
                        headerName: "Payment",
                        field: "paid",
                        sortable: true,
                        filter: true,
                        editable: true,
                    },



                ];
                this.editType = "fullRow";
            }
        },

        components: {
            "ag-grid-vue": AgGridVue,
            "app-loader": Loader
        }
    }
</script>

<style scoped>
    .dashbody {
        margin: 1px 10px 10px 10px;
        height: 100vh;
        overflow-y: hidden;
        /*border: thin #abdde5;*/
        /* border: 1px solid red; */
        /*box-shadow: 2px 2px 2px 2px #abdde5;*/
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
    .print-button-container {
        /* border: 1px solid black; */
        margin: 10px;
        padding: 20px;
        width: 93%;
        display: flex;
        justify-content: space-between;
    }

    .print-button-container button {
        width: 50px;
        height: 50px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        /* border: 1px solid red; */
        min-width: 150px;
        background-color: #5e9cd3;
        color: white;
    }

    .ag-header-group-cell-label {
        border: 1px solid red !important;
        text-align: center !important;
    }

    #exam-type {
        cursor: pointer;
        /* border: 1px solid black; */
        display: flex;
        justify-content: space-around;
        align-self: center;
        width: 200px;
        border: 1px solid rgb(140, 140, 140);
        /* padding: 10px; */
        box-sizing: border-box;
    }

    #exam-type-select {
        width: 85%;
        cursor: pointer;
        padding: 10px;
        height: 100%;
        border: none;
        outline: none;
    }

    i {
        display: flex;
        align-items: center;
    }
</style>