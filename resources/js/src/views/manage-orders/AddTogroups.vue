<template>
  <b-row>
    <b-col md="12">
      <b-card-code>
        <h4>Available Groups</h4>
        <br>

        <div class="custom-search d-flex justify-content-end">
          <b-form-group>
            <b-button v-if="isSelected" class="custom-btn" v-on:click="AddToGroup()">
              Add to {{ idArray.length }} Group<span v-if="idArray.length > 1">s</span> 
            </b-button>
          </b-form-group>
          <div style="margin-left:auto">
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
            <span v-if="props.column.field === 'fullName'" class="text-nowrap">
              <b-avatar :src="props.row.avatar" class="mx-1"/>
              <span class="text-nowrap">{{ props.row.fullName }}</span>
            </span>

            <!-- Column: Status -->
            <span v-else-if="props.column.field === 'status'">
              <b-badge :variant="statusVariant(props.row.status)">{{ props.row.status }}</b-badge>
            </span>

            <!-- Column: Action -->
            <span v-else-if="props.column.field === 'created_at'">
              <span>{{ new Date(props.row.created_at).toUTCString() }}</span>
            </span>
            <span v-else-if="props.column.field === 'action'">
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
                    <b-link :to="{ path: 'update-group/' + props.row.id}">Edit</b-link>
                  </b-dropdown-item>
                  <b-dropdown-item>
                    <feather-icon icon="CopyIcon" class="mr-50"/>
                    <b-link :to="{ path: 'copy-group/' + props.row.id}">Copy</b-link>
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

    <!-- buttons -->
    <b-col cols="12"></b-col>
    <!--/ buttons -->
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
  BLink,
  BRow,
  BCol,
  BButton,
  VBToggle,
  BSidebar
} from "bootstrap-vue";
import { VueGoodTable } from "vue-good-table";
import store from "@/store/index";
import Admin from "../../../api/admin";
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
    BLink,
    BRow,
    BCol,
    BButton,
    BSidebar
  },
  data() {
    return {
      pageLength: 3,
      dir: false,
      columns: [
        {
          label: "ID#",
          field: "id"
        },
        {
          label: "Name",
          field: "name"
        }
      ],
      rows: [],
      idArray: [],
      isSelected: false,
      searchTerm: "",
      status: [
        {
          1: "Yes",
          2: "No"
        },
        {
          1: "light-primary",
          2: "light-danger"
        }
      ]
    };
  },
  computed: {
    statusVariant() {
      const statusColor = {
        /* eslint-disable key-spacing */
        Yes: "light-primary",
        No: "light-danger"
        /* eslint-enable key-spacing */
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
    this.getUserGroups();
  },
  directives: {
    "b-toggle": VBToggle
  },

  methods: {
    getUserGroups() {
      const user_id = this.$route.params.id;
      Admin.getUserGroups(
        user_id,
        data => {
          this.rows = data.data;
          console.log("the user join grups data is ", data);
        },
        err => {
          console.log(err);
        }
      );
    },
    AddToGroup() {
      const user_id = this.$route.params.id;
      this.$swal({
        title: "Are you sure?",
        text: "User will be added to " + this.idArray.length + " group(s).",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Add User!",
        customClass: {
          confirmButton: "btn btn-primary",
          cancelButton: "btn btn-outline-danger ml-1"
        },
        buttonsStyling: false
      }).then(result => {
        if (result.value) {
          Admin.AddToGroup(
            user_id,
            this.idArray,
            data => {
              if (data.success) {
                console.log("the success response for Add to group is ", data);
                this.getUserGroups();
                this.$swal({
                  icon: "success",
                  title: "Added!",
                  text:
                    "User was be added to " + this.idArray.length + " groups.",
                  customClass: {
                    confirmButton: "btn btn-success"
                  }
                });
                this.idArray = [];
              } else {
                console.log("the error response for Add to group is ", data);
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
.custom-btn:focus {
  background-color: #7367f0 !important;
}
.custom-btn:hover {
  box-shadow: 0 8px 25px -8px #7367f0;
  color: white;
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
.custom-danger-btn:focus {
  background-color: #ee4b4b !important;
}
.custom-danger-btn:hover {
  box-shadow: 0 8px 25px -8px #ee4b4b;
  color: white;
}
</style>