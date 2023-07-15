<template>
  <div class="dashbody" v-show="this.isActiveComputed">
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
      :overlayNoRowsTemplate="overlayNoRowsTemplate"
    ></ag-grid-vue>
    <div class="print-button-container">
      <div id="exam-type">
        <select
          name="exam-type"
          id="exam-type-select"
          v-model="examtype"
          @change="getExaminationData()"
        >
          <option value>Select Exam type</option>
          <option v-for="exam in exams" :key="exam.id" :value="exam.id">{{exam.name}}</option>
        </select>
        <i class="fas fa-arrow-down"></i>
      </div>
      <button @click="getMarks()">
        <span v-if="marksheetLoading">
          <app-loader name="loader"></app-loader>
        </span>
        <span v-else>Print marksheet</span>
      </button>

      <button @click="getCsv()">
        <span>Export Excel sheet</span>
      </button>

      <button @click="getIndividualMark()">
        <span>Print selected marksheet</span>
      </button>

    </div>
  </div>
</template>

<script>
import axios from "axios";
import { AgGridVue } from "ag-grid-vue";
import Loader from "../modals/Loader";

export default {
  name: "Examination",
  props: {
    name: { required: true },
    isselected: { default: false },
    classId: { required: true },
    sectionId: { required: true }
  },

  data() {
    return {
      isActive: false,
      columnDefs: null,
      rowData: [],
      editType: null,
      loadingCellRenderer: null,
      loadingCellRendererParams: null,
      exams: [],
      examtype: "",
      loader: false,
      marksheetLoading: false,
      pinnedTopRowData: null,
      classname: this.$route.params.classname,
      sectionname: this.$route.params.sectionname,
      overlayNoRowsTemplate: `<h3>Please select exam type</h3>`
    };
  },
  computed: {
    href() {
      return "#" + this.name.toLowerCase().replace(/ /g, "-");
    },
    isActiveComputed() {
      return this.isActive;
    }
  },
  async created() {
    
  },
  mounted() {
    this.isActive = this.isselected;
  },
  methods: {
    getRowStyle(params) {
      return {
      };
    },
    async getCsv() {
      if (this.examtype === "") {
        this.$noty.error("Please choose exam type");
        return;
      }
      let columnsArr = this.columnApi.getAllColumns().map(col => col.colId);
      let columnKeys = columnsArr.filter(col => {
        return !(
          col.includes("thfm") ||
          col.includes("prfm") ||
          col.includes("student_id")
        );
      });

      this.gridApi.exportDataAsCsv({
        columnGroups: true,
        allColumns: true,
        columnKeys,
        fileName: `Ledger-${this.classname}-${this.sectionname}-${
          this.exams.find(exam => exam.id === this.examtype)["name"]
        }`
      });
      this.$noty.success("The ledger is downloaded");
    },

    redrawRow(i) {
      var row = this.gridApi.getDisplayedRowAtIndex(i);

      this.gridApi.redrawRows({ rowNodes: [row] });
    },
    rowSelected() {},

    async getIndividualMark(){
      this.marksheetLoading = true;
       if (this.examtype === "") {
        this.$noty.error("Please choose exam type");
        this.marksheetLoading = false;
        return;
      }
      let student_ids_array = this.gridApi.getSelectedRows().map( node => {
        return node.student_id;
      })
      // debugger;
      // console.log(student_ids);
      let response = await axios.post(`/marks/list/`, {
        section_id: this.sectionId,
        exam_id: this.examtype,
        student_ids: student_ids_array
      });
      axios({
        method: "POST",
        url: "http://pdf-generator.itglance.org/test",
        headers: {
          Accept: "application/pdf"
        },
        timeout: 1000 * 180,
        responseType: "blob",
        data: response.data
      })
      .then(response => {
          const url = window.URL.createObjectURL(
            new Blob([response.data], { type: "application/pdf" })
          );
          const link = document.createElement("a");
          link.href = url;
          link.setAttribute(
            "download",
            `Marksheet-${this.classname}-${this.sectionname}-${
              this.exams.find(exam => exam.id === this.examtype)["name"]
            }`
          );
          document.body.appendChild(link);
          link.click();
          this.$noty.success("The marksheet is downloaded");

        axios.get(`student/${this.sectionId}`)
        .then(res=>res.data.data.map( x =>
        {
          axios.post("/studentHistory/" + x.id +"/"+ this.examtype, {event:'ExamDetail'})
        }
        ))

        })
        .catch(err => {
          this.$noty.error("Error while downloading marksheet");
        })
        .finally(() => {
          this.marksheetLoading = false;
        });
    },

    async getMarks() {
      this.marksheetLoading = true;
      if (this.examtype === "") {
        this.$noty.error("Please choose exam type");
        this.marksheetLoading = false;
        return;
      }
      let response = await axios.post(`/marks/list/`, {
        section_id: this.sectionId,
        exam_id: this.examtype
      });

      axios({
        method: "POST",
        url: "http://pdf-generator.itglance.org/test",
        headers: {
          Accept: "application/pdf"
        },
        timeout: 1000 * 180,
        responseType: "blob",
        data: response.data
      })
        .then(response => {
          const url = window.URL.createObjectURL(
            new Blob([response.data], { type: "application/pdf" })
          );
          const link = document.createElement("a");
          link.href = url;
          link.setAttribute(
            "download",
            `Marksheet-${this.classname}-${this.sectionname}-${
              this.exams.find(exam => exam.id === this.examtype)["name"]
            }`
          );
          document.body.appendChild(link);
          link.click();
          this.$noty.success("The marksheet is downloaded");

        axios.get(`student/${this.sectionId}`)
        .then(res=>res.data.data.map( x =>
        {
          axios.post("/studentHistory/" + x.id +"/"+ this.examtype, {event:'ExamDetail'})
        }
        ))

        })
        .catch(err => {
          this.$noty.error("Error while downloading marksheet");
        })
        .finally(() => {
          this.marksheetLoading = false;
        });
    },
    async getExaminationData() {
      if (!this.examtype) {
        this.gridApi.showNoRowsOverlay();
        this.rowData = null;
        return;
      }
      await this.gridApi.showLoadingOverlay();
      let fullmarks = await axios.get(
        `/marks/${this.sectionId}/fullmarks/${this.examtype}`
      );

      if (this.examtype !== "") {
        this.loader = true;
        axios
          .get(`/marksfetch/${this.sectionId}/${this.examtype}/1`)
          .then(res => {
            let fullMarksData = {
              student_id: "fullmarks",
              ...fullmarks.data
            };
            this.pinnedTopRowData = [fullMarksData];

            this.rowData = res.data;
            this.loader = false;
            this.gridApi.hideOverlay();
          })
          .catch(async e => {
            this.gridApi.hideOverlay();
            this.rowData = [];
            this.$noty.error("Error while loading data from the server");
          });
      } else {
      }
    },
    onGridReady(params) {
      this.gridApi = params.api;
      this.columnApi = params.columnApi;
      this.getExaminationData();
    },
    rowValueChanged: async function(event) {
      if (event.data.student_id === "fullmarks") {
        this.updateDefaultMarks(event);
        return;
      }
      let finalData = {};
      this.subjects
        .map(s => s.name)
        .forEach(name => {
          finalData[name.toLowerCase()] = {
            theory: 0,
            practical: 0,
            total: 0
          };
        });
      let data = event.data;
      for (let sub in data) {
        let [name, type] = sub.split("-");
        if (type === undefined) {
          continue;
        } else {
          finalData[name] && (finalData[name.toLowerCase()][type] = data[sub]);
        }
      }

      let marks = [];
      for (let sub in finalData) {
        marks.push({
          subject: this.subjects.find(s => s.name.toLowerCase() === sub)[
            "subject_id"
          ],
          theory: Number(finalData[sub].theory),
          practical: Number(finalData[sub].practical)
        });
      }

      let response = {
        exam: this.examtype,
        section: this.sectionId,
        exam_details: [
          {
            student_id: event.data.student_id,
            marks
          }
        ]
      };
      try {
        let re = await axios.post("/marks/entry", response);
        this.$noty.success("Successfully updated");
      } catch (e) {
        this.$noty.error("Oops, something went wrong!");
      }
    },
    async updateDefaultMarks(event) {
      let response = await axios.post(
        `/marks/${this.sectionId}/store/${this.examtype}/fullmarks`,
        event.data
      );
    },
    async getSubjectData() {
      let res = await axios.get(`sectionsubject/${this.sectionId}`);
      let exams = await axios.get("/exam");

      this.exams = exams.data.exams;
      this.subjects = res.data.subject_data;

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
        ...this.subjects
          .map(sub => sub.name)
          .map(sub => ({
            headerName: sub,
            field: sub,
            sortable: true,
            filter: true,
            editable: true,
            children: [
              {
                headerName: "Theory",
                field: `${sub.toLowerCase()}-theory`,
                width: 100,
                editable: true
              },
              {
                headerName: "Practical",
                field: `${sub.toLowerCase()}-practical`,
                width: 100,
                editable: true
              },
              {
                headerName: "Grade",
                field: `${sub.toLowerCase()}-full_grade`,
                width: 100,
                editable: true,
                hide: true,
                suppressToolPanel: true
              }
            ]
          })),
        {
          headerName: "Grade",
          field: "full_grade",
          hide: true,
          suppressToolPanel: true
        },
        {
          headerName: "Total marks",
          field: "full_obtained",
          hide: true,
          suppressToolPanel: true
        },
        {
          headerName: "GPA",
          field: "full_pa",
          hide: true,
          suppressToolPanel: true
        },
        {
          headerName: "Percentage",
          field: "full_percentage",
          hide: true,
          suppressToolPanel: true
        },
        {
          headerName: "Rank",
          field: "roll_computed",
          hide: true,
          suppressToolPanel: true
        }
      ];

      this.editType = "fullRow";
    }
  },
  watch: {
    sectionId: function() {
      this.getSubjectData();
      this.getExaminationData();
    },
    isActive: function() {
      if (this.isActive) {
        this.getSubjectData();
        this.getExaminationData();
      }
    },
    $route(to, from) {
      this.classname = to.params.classname;
      this.sectionname = to.params.sectionname;
    }
  },
  components: {
    "ag-grid-vue": AgGridVue,
    "app-loader": Loader
  }
};
</script>

<style scoped>
.dashbody {
  margin: 1px 10px 10px 10px;
  height: 100vh;
  overflow-y: hidden;
}

.print-button-container {
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
  display: flex;
  justify-content: space-around;
  align-self: center;
  width: 200px;
  border: 1px solid rgb(140, 140, 140);
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