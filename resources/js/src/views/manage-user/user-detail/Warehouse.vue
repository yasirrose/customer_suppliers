<template>
  <b-row>
    <b-col cols="12">
      <b-card-code>
        <!-- <b-link :to="{ path: 'create-user' }" class="custom-btn">Create a New User</b-link>
        <b-link :to="{ path: 'create-user' }" class="custom-btn">Start User Import Wizard</b-link>
        <b-button class="custom-btn" v-b-toggle.sidebar-border>View Summary</b-button> -->
        <!-- <b-button v-if="isSelected" class="custom-danger-btn" @click="actionRecords('delete')">
          Delete {{ idArray.length }} Record
          <span v-if="idArray.length > 1">s</span>
        </b-button>
        <b-button v-if="isSelected" class="custom-danger-btn" @click="actionRecords('enable')">
          Enable {{ idArray.length }} Record
          <span v-if="idArray.length > 1">s</span>
        </b-button>
        <b-button v-if="isSelected" class="custom-danger-btn" @click="actionRecords('disable')">
          Dieable {{ idArray.length }} Record
          <span v-if="idArray.length > 1">s</span>
        </b-button> -->
        <b-sidebar id="sidebar-border" sidebar-class="border-right border-primary">
          <div class="px-3 py-2">
            <div class="mt-md-0 mt-2">
              <h1 class="invoice-title">
                <b>SUMMARY</b>
              </h1>
              <table class="vgt-table bordered" id="vgt-table">
                <tr></tr>
                <tr>
                  <th>Total Users:</th>
                  <td>{{ rows.length }}</td>
                </tr>
                <tr>
                  <th>Total Approved Users:</th>
                  <td>{{ approved_users }}</td>
                </tr>
                <tr>
                  <th>Total Disabled Users:</th>
                  <td>{{ disabled_users }}</td>
                </tr>
              </table>
            </div>
          </div>
        </b-sidebar>
        <!-- search input -->
        <div class="custom-search d-flex justify-content-end">
          <b-form-group>
            <div class="d-flex align-items-center">
              <label class="mr-1">Search</label>
              <b-form-input
                v-model="searchTerm"
                placeholder="Search"
                type="text"
                class="d-inline-block"
              />
            </div>
          </b-form-group>
        </div>

        <!-- table -->
        <vue-good-table
          :columns="columns"
          :rows="rows"
          @on-selected-rows-change="selectionChanged"
          :rtl="direction"
          :search-options="{
                enabled: true,
                externalQuery: searchTerm }"
          :select-options="{
                enabled: true,
                selectOnCheckboxOnly: true, // only select when checkbox is clicked instead of the row
                selectionInfoClass: 'custom-class',
                selectionText: 'rows selected',
                clearSelectionText: 'clear',
                disableSelectInfo: true, // disable the select info panel on top
                selectAllByGroup: true, // when used in combination with a grouped table, add a checkbox in the header row to check/uncheck the entire group
            }"
          :pagination-options="{
                enabled: true,
                perPage:pageLength
            }"
        >
          <template slot="table-row" slot-scope="props">
             <!-- Column: Name -->
           
            
            <span v-if="props.column.field === 'name'">
             
                <b-link :to="{path : `/warehouse-detail/${props.row.id}`}">{{ props.row.name }}</b-link>
             
            </span>
            <!-- Column: Date -->
           
            <span v-else-if="props.column.field === 'created_at'">
              <span>{{ new Date(props.row.created_at).toUTCString() }}</span>
            </span>
            <!-- Column: Action -->
            <span v-else-if="props.column.field === 'action' && props.row.is_admin != 1">
              <span>
                <b-dropdown variant="link" toggle-class="text-decoration-none" no-caret>
                  <template v-slot:button-content>
                    <feather-icon
                      icon="MoreVerticalIcon"
                      size="16"
                      class="text-body align-middle mr-25"
                    />
                  </template>
                  <b-dropdown-item>
                    <feather-icon icon="Edit2Icon" class="mr-50"/>
                    <b-link :to="{ path: '/update-warehouse/'+ props.row.id}">Edit</b-link>
                  </b-dropdown-item>
                  
                </b-dropdown>
              </span>
            </span>

            <!-- Column: Common -->
            <span v-else>{{ props.formattedRow[props.column.field] }}</span>
          </template>

          <!-- pagination -->
          <template slot="pagination-bottom" slot-scope="props">
            <div class="d-flex justify-content-between flex-wrap">
              <div class="d-flex align-items-center mb-0 mt-1">
                <span class="text-nowrap">Showing 1 to</span>
                <b-form-select
                  v-model="pageLength"
                  :options="['3','5','10']"
                  class="mx-1"
                  @input="(value)=>props.perPageChanged({currentPerPage:value})"
                />
                <span class="text-nowrap">of {{ props.total }} entries</span>
              </div>

              <div>
                <b-pagination
                  :value="1"
                  :total-rows="props.total"
                  :per-page="pageLength"
                  first-number
                  last-number
                  align="right"
                  prev-class="prev-item"
                  next-class="next-item"
                  class="mt-1 mb-0"
                  @input="(value)=>props.pageChanged({currentPage:value})"
                >
                  <template #prev-text>
                    <feather-icon icon="ChevronLeftIcon" size="18"/>
                  </template>
                  <template #next-text>
                    <feather-icon icon="ChevronRightIcon" size="18"/>
                  </template>
                </b-pagination>
              </div>
            </div>
          </template>
        </vue-good-table>
      </b-card-code>
    </b-col>
  </b-row>
</template>

<script>
import BCardCode from "@core/components/b-card-code/BCardCode.vue";
import {
  BAvatar,
  BBadge,
  BPagination,
  BFormGroup,
  BFormInput,
  BFormSelect,
  BDropdown,
  BDropdownItem,
  BRow,
  BCol,
  BLink,
  BButton,
  BSidebar,
  VBToggle
} from "bootstrap-vue";
import { VueGoodTable } from "vue-good-table";
import store from "@/store/index";
import Admin from "../../../../api/admin";

export default {
  components: {
    BCardCode,
    VueGoodTable,
    BAvatar,
    BBadge,
    BPagination,
    BFormGroup,
    BFormInput,
    BFormSelect,
    BDropdown,
    BDropdownItem,
    BRow,
    BCol,
    BLink,
    BButton,
    BSidebar
  },
  data() {
    return {
      pageLength: 3,
      dir: false,
      id:this.$route.params.id,
      columns: [
        {
          label: "Warehouse Name",
          field: "name"
        },
        {
          label: "Location Index",
          field: "location_index"
        },
        {
          label: "Created At",
          field: "created_at"
        },
        {
          label: "Action",
          field: "action"
        }
      ],
      rows: [],
      searchTerm: "",
      idArray: [],
      isSelected: false,
      disabled_users: 0,
      approved_users: 0,
      status: [
        {
          1: "1",
          2: "0"
        },
        {
          1: "light-primary",
          2: "light-success",
          3: "light-danger",
          4: "light-warning",
          5: "light-info"
        }
      ]
    };
  },
  computed: {
    statusVariant() {
      const statusColor = {
        /* eslint-disable key-spacing */
        1: "light-primary",
        0: "light-danger"
      };

      return status => statusColor[status];
    },
    direction() {
      if (store.state.appConfig.isRTL) {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        this.dir = true;
        return this.dir;
      }
      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      this.dir = false;
      return this.dir;
    }
  },
  created() {
    this.getWarehouseDetail(this.id);
  },
  directives: {
    "b-toggle": VBToggle
  },
  methods: {
    getWarehouseDetail(userId) {
      Admin.getWarehouseDetail(
        userId,
        data => {
          this.rows = data.data;
          this.approved_users = 0;
          this.disabled_users = 0;
          this.rows.forEach((value, index) => {
            this.approved_users += +value.approved_users;
            this.disabled_users += +value.disabled_users;
          });
        },
        err => {
          console.log(err);
        }
      );
    },
    actionRecords(param) {
      if (param == "delete") {
        var text = "You won't be able to revert this!";
        var buttonText = "Yes, delete them!";
        var responseText = "Selected records been deleted.";
        var responseTitle = "Deleted!";
      } else if (param == "enable") {
        var text = "You want to enable the selected items?";
        var buttonText = "Yes, enable them!";
        var responseText = "Selected records been enabled.";
        var responseTitle = "Enabled!";
      } else if (param == "disable") {
        var text = "You want to disable the selected items?";
        var buttonText = "Yes, disable them!";
        var responseText = "Selected records been disabled.";
        var responseTitle = "Disabled!";
      }
      this.$swal({
        title: "Are you sure?",
        text: text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: buttonText,
        customClass: {
          confirmButton: "btn btn-primary",
          cancelButton: "btn btn-outline-danger ml-1"
        },
        buttonsStyling: false
      }).then(result => {
        if (result.value) {
          Admin.deleteUser(
            (this.info = {
              id: this.idArray,
              param: param
            }),
            data => {
              if (data.success) {
                this.getUsers();
                this.$swal({
                  icon: "success",
                  title: responseTitle,
                  text: responseText,
                  customClass: {
                    confirmButton: "btn btn-success"
                  }
                });
              }
            },
            err => {
              console.log(err);
            }
          );
        }
      });
    },
    selectionChanged(params) {
      this.idArray = params.selectedRows;
      if (this.idArray.length > 0) {
        this.isSelected = true;
      } else {
        this.isSelected = false;
      }
    }
  }
};
</script>

<style lang="scss">
@import "~@core/scss/vue/libs/vue-good-table.scss";
.custom-btn {
  border-color: #7367f0 !important;
  background-color: #7367f0 !important;
  color: white;
  text-align: center;
  border: 1px solid transparent;
  padding: 0.786rem 1.5rem;
  border-radius: 0.358rem;
  cursor: pointer;
  height: 43px;
}
.custom-btn:hover {
  box-shadow: 0 8px 25px -8px #7367f0;
  color: white;
}
.custom-btn:focus {
  background-color: #7367f0 !important;
}

.custom-danger-btn {
  border-color: #ee4b4b !important;
  background-color: #ee4b4b !important;
  color: white;
  text-align: center;
  border: 1px solid transparent;
  padding: 0.786rem 1.5rem;
  border-radius: 0.358rem;
  cursor: pointer;
  height: 43px;
}
.custom-danger-btn:hover {
  box-shadow: 0 8px 25px -8px #ee4b4b;
  color: white;
}
.custom-danger-btn:focus {
  background-color: #ee4b4b !important;
}
</style>