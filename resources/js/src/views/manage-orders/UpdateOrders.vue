<template>
  <b-row>
    <b-col cols="12">
      <b-card-code title="Update Order">
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
                  <validation-provider #default="{ errors }" name="Order Type" rules="required">
                    <b-form-select
                      v-model="orderType"
                      v-on:change="getRelUsers($event)"
                      :options="order_type"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Order For" rules="required">
                    <b-form-select v-model="createdFor" :options="created_for"/>
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Order Title" rules="required">
                    <b-form-input
                      v-model="orderTitle"
                      :state="errors.length > 0 ? false:null"
                      type="text"
                      placeholder="Order Title"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Product" rules="required">
                    <b-form-select v-model="productId" :options="all_products"/>
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
                      placeholder="Quantity"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>

              

              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="description" rules="required">
                    <b-form-textarea
                      id="textarea"
                      v-model="description"
                      placeholder="Enter something..."
                      rows="2"
                      max-rows="6"
                    ></b-form-textarea>
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
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
  BFormCheckbox,
  BFormTextarea
} from "bootstrap-vue";
import { required } from "@validations";
import AdminApi from "../../../api/admin";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import router from "@/router";
import Admin from "../../../api/admin";

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
    BFormCheckbox,
    BFormTextarea
  },
  data() {
    return {
       productId:null,
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
      ],
      all_products: [
        { value: null, text: "Select a product" },
       
      ],
      validationErrors: '',
    orderId : this.$route.params.id,
    };
  },
  created() {
      this.getAllProducts();
    this.getSingleOrder(this.orderId);
  },
  methods: {
    validationForm() {
      this.$refs.simpleRules.validate().then(success => {
        if (success) {
          this.validationErrors = "";
          AdminApi.updateProduct(
            (this.info = {
              name: this.productName,
              length: this.length,
              width: this.width,
              weight: this.weight,
              description: this.description,
              type_id: this.productType,
              id:this.productId
             
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
                //router.push({ name: "manage-users" });
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
    },
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
    getAllProducts()
    {
      AdminApi.getAllProducts(res=>{
        for (let i = 0; i < res.data.length; i++) {
            this.all_products.push({
              value: res.data[i].id,
              text: res.data[i].name
            });
          }
      },
      err=>{
        console.log(err)
      });
    },
    getSingleOrder(orderId) {
      Admin.getSingleOrder(
        orderId,
        res => {
          console.log('the getSingleOrder response is', res.data);
        //   this.productName = res.data.name,
      
          
        },
        err => {
          console.log(err);
        }
      );
    }
  }
};
</script>