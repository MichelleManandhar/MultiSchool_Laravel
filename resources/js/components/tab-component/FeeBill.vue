<template>
    <div class="dashbody" v-show="this.isActiveComputed">
        {{year}} /{{month}}
        <ag-grid-vue
                ref="ids"
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
        <div class="print-button-container">

            <button @click="printBillForAll">
                <!-- Get marksheet   -->

                <span >Print Bill for all</span>
            </button>

            <button @click="printBillForAll">

                <span >Print Bill </span>
            </button>
        </div>
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
        name: "Fee",
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
                marksheetLoading: false,
                pinnedTopRowData: null,
                classname: this.$route.params.classname,
                sectionname: this.$route.params.sectionname,
                rowClassRules: null,
                gridOptions: null,
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
            this.feeData();
            this.getFeeCategoryData();
            this.updateSectionFeeForAll();
            var res = await axios.get(`/fee/setupfee/${this.sectionId}`);
            this.feeSetup = res.data;
            eventBus.$on('payment-update' , this.feeData);
            eventBus.$on('update-student' , this.feeData);
            eventBus.$on('update-fee-cat' , this.feeData);
        },
        async beforeMount(){
            this.gridOptions = {};
            this.rowData = [];
            var res = await axios.get(`/fee/setupfee/${this.sectionId}`);
            this.feeSetup = res.data;
        },
        methods: {
            printBillForAll(){

                axios({
                    method: "POST",
                    url: "http://localhost/pdfGenerator/pdf-generator/layouts/bill_layout.hbs",
                    headers: {
                        Accept: "application/pdf"
                    },
                    timeout: 1000 * 180,
                    responseType: "blob",
                    data: this.rowData
                })
                    .then(response => {
                        // const url = window.URL.createObjectURL(
                        //     new Blob([response.data], { type: "application/pdf" })
                        // );
                        // const link = document.createElement("a");
                        // link.href = url;
                        // link.setAttribute(
                        //     "download",
                        //     `Marksheet-${this.classname}-${this.sectionname}-${
                        //         this.exams.find(exam => exam.id === this.examtype)["name"]
                        //         }`
                        // );
                        // document.body.appendChild(link);
                        // link.click();
                        // this.$noty.success("The marksheet is downloaded");
                    })
                    .catch(err => {
                        this.$noty.error("Error while downloading narksheet");
                    })
                    .finally(() => {
                        this.marksheetLoading = false;
                    }
                )
            },
            getRowStyle(params) {
                return {
                };
            },
            updateSectionFeeForAll(){
                axios.get(
                    `/fee/setupfee/${this.sectionId}`
                ).then((res) =>function(res){
                    this.feeData();
                });
            },
            rowValueChanged: async function(event) {

                if (event.data.student_id === "fee_allocate") {
                    this.updateFeeAllocation(event);
                }

                else  {
                    this.updateFeeForStudents(event);
                }
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

            updateFeeAllocation(event) {
                console.log(event);
                axios.post(
                    `/fee/store/${this.sectionId}`,
                    event.data
                ).then(response=>{
                    this.$noty.success(response.data.message);
                    this.feeData();
                });
            },

            async updateFeeForStudents(event) {
                console.log(event);
                let response = await axios.post(
                    `/fee/storefee/${this.sectionId}/${event.data.id}`,
                    event.data
                )
                if(response.data.status === 1){
                    eventBus.$emit('bill-changed');
                    this.$noty.success(response.data.message);
                    this.feeData();
                }
            },

            async feeData(){
                var resp = await axios.get(`/fee/setupfee/${this.sectionId}`);
                this.feeSetup = resp.data;
                await axios.get(`/fee/${this.sectionId}`)
                    .then(res => {
                        let feeAllocate = {
                            student_id: "fee_allocate",
                            ...this.feeSetup,
                            dueAmount : '-',
                            total : '-'
                        };
                        this.pinnedTopRowData = [feeAllocate];
                        this.rowData = res.data;
                        this.loader = false;
                        this.gridApi.hideOverlay();
                    })
                    .catch(async e => {
                        this.gridApi.hideOverlay();
                        this.rowData = [];
                        this.$noty.error("Error while loading data from the server");
                    });
            },
            async getFeeCategoryData() {
                let res = await axios.get(`feeCategory/`);
                this.feeCategory = res.data.feeCategories;
                this.columnDefs = [
                    {
                        headerName: "Student id",
                        field: "student_id",
                        hide: true,
                        suppressToolPanel: true
                    },
                    {
                        headerName: "Roll",
                        field: "roll_no",
                        width: 50,
                        sortable: true,
                        pinned: "left"
                    },
                    {
                        headerName: "Student Name",
                        field: "name",
                        sortable: true,
                        filter: true,
                        pinned: "left"
                    },
                    ...this.feeCategory
                        .map((sub) => ({
                            headerName: sub.name,
                            field: sub.name,
                            sortable: true,
                            filter: true,
                            editable: true,

                        }))
                    ,
                    {
                        headerName: "Due Amount ",
                        field: "dueAmount",
                        sortable: true,
                        filter: true,
                        editable: false,
                    },
                    {
                        headerName: "Total Fee",
                        field: "total",
                        sortable: true,
                        filter: true,
                        editable: false,
                    },
                    {
                        headerName: "Paid Fee",
                        field: "paid_fee",
                        sortable: true,
                        filter: true,
                        editable: false,
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