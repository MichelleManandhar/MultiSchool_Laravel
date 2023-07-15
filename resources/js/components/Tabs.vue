 <template>
  <div class="tabs">
    <div class="tab-headers">
      <div
        class="header-item"
        v-for="(tab,index) in tabs"
        :class="{ 'is-active' : tab.isActive }"
        :key="index"
      >
        <a :href="tab.href" @click="selectedTab(tab.name)">{{tab.name}}</a>
      </div>
    </div>
    <div class="tabs-detail">
      <app-teacher name="Teacher" :classId="classId" :sectionId="sectionId"></app-teacher>
      <app-attendance name="Attendance" isselected="true" :classId="classId" :sectionId="sectionId"></app-attendance>
      <app-subject name="Subject" :classId="classId" :sectionId="sectionId"></app-subject>
      <app-student name="Student" :classId="classId" :sectionId="sectionId" isselected="true"></app-student>
      <app-examination name="Examination" :classId="classId" :sectionId="sectionId"></app-examination>
      <app-fee name="FeeBill" :classId="classId" :sectionId="sectionId"></app-fee>
      <app-feepayment name="FeePayment" :classId="classId" :sectionId="sectionId"></app-feepayment>
      <app-idcards name="Idcards" :classId="classId" :sectionId="sectionId"></app-idcards>

    </div>
  </div>
</template>

<script>
import Teacher from "./tab-component/Teacher";
import Attendance from "./tab-component/Attendance";
import Subject from "./tab-component/Subject";
import Student from "./tab-component/Student";
import FeeBill from "./tab-component/FeeBill";
import FeePayment from "./tab-component/FeePayment";
import Examination from "./tab-component/Examination";
import Idcards from "./tab-component/Idcards";

export default {
  name: "Tabs",
  components: {
    "app-teacher": Teacher,
    "app-attendance": Attendance,
    "app-subject": Subject,
    "app-student": Student,
    "app-examination": Examination,
    "app-idcards": Idcards,
      "app-fee": FeeBill,
      "app-feepayment": FeePayment,
  },
  data() {
    return {
      tabs: [],
      sectionId: this.$route.params.sectionid,
      classId: this.$route.params.classid
    };
  },
  created() {
    eventBus.$on("tabChange", data => {
      this.assignClassSection(data);
      this.selectedTab(data.tabName);
    });
    eventBus.$on("sectionChange", data => {
      this.assignClassSection(data);
    });
    this.tabs = this.$children;
  },
  methods: {
    selectedTab(selectedTab) {
      this.tabs.forEach(tab => {
        tab.isActive = tab.name === selectedTab;
      });
      eventBus.$emit("breadCrumbTabChange", {
        tabName: selectedTab
      });
    },
    assignClassSection(data) {
      this.sectionId = data.sectionId;
      this.classId = data.classId;
    }
  },
  watch: {
    $route(to, from) {
      this.classId = to.params.classid;
      this.sectionId = to.params.sectionid;
    }
  }
};
</script>

<style>
.tabs {
  display: flex;
  flex-direction: column;
}
.tab-headers {
  display: flex;
  width: 30vw;
  z-index: 0;
  padding: 0 8px;
}
.header-item {
  padding: 8px;
  height: 30px;
  width: 100px;
  font-size: 13px;
  border-right: 6px solid white;
  background-color: #c9c9c9;
  color: #f5f5f5;
  display: flex;
  justify-content: center;
  align-items: center;
  border-left: 6px solid white;
}

.header-item a {
  text-decoration: none;
}
.is-active {
  border: 1px solid #c9c9c9;
  border-bottom: white;
  background-color: white;
  border-collapse: collapse;
  position: relative;
}
.is-active::after {
  content: " ";
  position: absolute;
  bottom: -2px;
  background: white;
  height: 12%;
  width: 100%;
  left: 0;
  z-index: 999;
}
</style>