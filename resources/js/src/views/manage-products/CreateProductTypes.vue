<template>
  <b-row>
    <b-col cols="12">
      <b-card-code title="Create Product Types">
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
                  <validation-provider #default="{ errors }" name="Product Type" rules="required">
                    <b-form-input
                      v-model="productType"
                      :state="errors.length > 0 ? false:null"
                      type="text"
                      placeholder="Enter a Product Type"
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
      productType: "",
     
      validationErrors: '',
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
          AdminApi.addProductType(
            (this.info = {
              type: this.productType,
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
                 this.$router.push({ name: "manage-products" });
                //this.$router.go()
                
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