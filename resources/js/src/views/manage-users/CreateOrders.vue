<template>
  <b-row>
    <b-col cols="12">
      <b-card-code title="Add Users">
        <div v-if="validationErrors">
          <ul class="alert alert-danger">
            <li v-for="(value, key, index) in validationErrors">{{ value }}</li>
          </ul>
        </div>
        <validation-observer ref="simpleRules">
          <b-form>
            <b-row>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Order Title" rules="required">
                    <b-form-input
                      v-model="orderTitle"
                      :state="errors.length > 0 ? false:null"
                      type="text"
                      placeholder="First Name"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Quantity" rules="required">
                    <b-form-input
                      v-model="quantity"
                      type="text"
                      :state="errors.length > 0 ? false:null"
                      placeholder="Last Name"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Quantity" rules="required">
                    <b-form-input
                      v-model="quantity"
                      type="text"
                      :state="errors.length > 0 ? false:null"
                      placeholder="Email"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Quantity" rules="required">
                    <b-form-input
                      v-model="quantity"
                      type="text"
                      :state="errors.length > 0 ? false:null"
                      placeholder="User Type"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>


              <!-- submit button -->
              <b-col md="12">
                <b-button variant="primary" type="submit" @click.prevent="validationForm">Submit</b-button>
              </b-col>
            </b-row>
          </b-form>
        </validation-observer>
      </b-card-code>
    </b-col>
  </b-row>
</template>
<script>
import BCardCode from "@core/components/b-card-code";
import { ValidationProvider, ValidationObserver } from "vee-validate";
import {
  BFormInput,
  BFormGroup,
  BForm,
  BRow,
  BCol,
  BButton,
  BFormSelect,
  BFormTextarea
} from "bootstrap-vue";
import { required, email, confirmed } from "@validations";
import AdminApi from "../../../api/admin";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";

export default {
  components: {
    BCardCode,
    ValidationProvider,
    ValidationObserver,
    BFormInput,
    BFormGroup,
    BForm,
    BRow,
    BCol,
    BButton,
    BFormSelect,
    BFormTextarea
  },
  data() {
    return {
      orderTitle: "",
      quantity: "",
      orderType: null,
      createdFor: null,
      description: "",

      created_for: [{ value: null, text: "Please select a User" }],
      order_type: [
        { value: null, text: "Please select Order Type" },
        { value: "3", text: "Sales Order" },
        { value: "2", text: "Purchase Order" }
      ]
    };
  },
  methods: {
    getRelUsers(event) {
      
      console.log("the user type is", event);
      this.createdFor = null;
       this.created_for = null;
      this.created_for = [{ value: null, text: "Please select a User" }];
      AdminApi.getRelUsers(
        res => {
          console.log("the getRelUsers response is ", res.data);
          for (let i = 0; i < res.data.length; i++) {
            this.created_for.push({
              value: res.data[i].id,
              text: res.data[i].first_name
            });
          }
        },
        err => {
          console.log(err);
        },
        event
      );
    },
    validationForm() {
      const user = JSON.parse(localStorage.getItem("userData"));
     
      this.$refs.simpleRules.validate().then(success => {
        if (success) {
          this.validationErrors = "";
          AdminApi.saveOrder(
            (this.info = {
              title: this.orderTitle,
              description: this.description,
              quantity: this.quantity,
              type: this.orderType,
              status:1,
              created_by:user.id,
              created_for: this.createdFor,
             
            }),
            data => {
              if (data.success) {
                this.$toast({
                  component: ToastificationContent,
                  props: {
                    title: "Success!",
                    text: data.message,
                    icon: "UserIcon",
                    variant: "success"
                  }
                });
                //router.push({ name: "view-orders" });
                
              } else {
                if (data.status == 422) {
                  this.validationErrors = data.message;
                } else {
                  this.$toast({
                    component: ToastificationContent,
                    props: {
                      title: "Failed",
                      text: data.message,
                      icon: "errorIcon",
                      variant: "outline-danger"
                    }
                  });
                }
              }
            },
            err => {
              console.log(err);
            }
          );
        }
      });
    }
  }
};
</script>