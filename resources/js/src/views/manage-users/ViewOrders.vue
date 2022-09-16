<template>
  <b-card>
    <b-row>
       <b-col md="8">
      <b-card no-body>
        <b-card-header>
          <b-card-title>
            <h4>All Users</h4>
            
          </b-card-title>
        </b-card-header>
        <b-card-body>
         
        </b-card-body>
      </b-card>
       </b-col>

      <!-- buttons -->
      <!-- <b-col cols="12">
        <b-button
          v-ripple.400="'rgba(255, 255, 255, 0.15)'"
          variant="primary"
          class="mr-1 mt-1"
        >Save changes</b-button>
        <b-button
          v-ripple.400="'rgba(186, 191, 199, 0.15)'"
          type="reset"
          class="mt-1"
          variant="outline-secondary"
        >Cancel</b-button>
      </b-col> -->
      <!--/ buttons -->
    </b-row>
  </b-card>
</template>

<script>
import {
  BButton,
  BRow,
  BCol,
  BCard,
  BFormCheckbox,
  BTabs,
  BTab,
  BCardTitle,
  BCardText,
  BCardHeader,
  BCardBody
} from "bootstrap-vue";
import {} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import AdminApi from "../../../api/admin";

export default {
  components: {
    BButton,
    BRow,
    BCol,
    BCard,
    BFormCheckbox,
    BTabs,
    BTab,
    BCard,
    BCardTitle,
    BCardText,
    BCardHeader,
    BCardBody
  },
  directives: {
    Ripple
  },
  props: {
    notificationData: {
      type: Object,
      default: () => {}
    }
  },
  data() {
    return {
      first_name: "",
      last_name: "",
      username: "",
      email: "",
      mobile: "",
      created_at: "",
      updated_at: "",
      force_password_reset: "",
      status: "",
      roles: "",
      groups: ""
    };
  },
    created() {
    this.getUserDetails();
  },
  methods: {
    getUserDetails() {
      const user_id = this.$route.params.id;
      AdminApi.getUserDetails(
        res => {
          
          this.first_name = res.data.first_name;
          this.last_name = res.data.last_name;
          this.email = res.data.email;
          this.mobile = res.data.mobile;
          this.username = res.data.username;
          this.created_at = res.data.created_at;
          this.updated_at = res.data.updated_at;
          this.status = res.data.status;
          

          console.log("the user detail response is ", res);
        },
        err => {
          console.log(err);
        },
        user_id
      );
    }
  }
};
</script>
