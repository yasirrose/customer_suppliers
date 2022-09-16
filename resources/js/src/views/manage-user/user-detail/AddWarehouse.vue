<template>
  <b-row>
    <b-col cols="12">
      <b-card-code title="Add Warehouse">
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
                <validation-provider
                    #default="{ errors }"
                    name="Warehouse Name"
                    rules="required"
                >
                    <b-form-input
                    v-model="name"
                    :state="errors.length > 0 ? false:null"
                    type="text"
                    placeholder="Please Enter Warehouse Name"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
                </b-form-group>
            </b-col>
            <b-col md="6">
                <b-form-group>
                <validation-provider
                    #default="{ errors }"
                    name="Warehouse Location"
                    rules="required"
                >
                    <b-form-input
                    v-model="location"
                    :state="errors.length > 0 ? false:null"
                    type="text"
                    placeholder="Please Enter Warehouse Location"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
                </b-form-group>
            </b-col>
            
            
            <b-col>
                <b-button
                variant="primary"
                type="submit"
                @click.prevent="validationForm"
                >
                Submit
                </b-button>
            </b-col>
            </b-row>
        </b-form>
        </validation-observer>
    </b-card-code>
    </b-col>
  </b-row>
</template>
<script>
import BCardCode from '@core/components/b-card-code'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
  BFormInput, BFormGroup, BForm, BRow, BCol, BButton, BFormSelect, BFormCheckbox 
} from 'bootstrap-vue'
import {
  required
} from '@validations'
import AdminApi from '../../../../api/admin'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import router from '@/router'


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
    BFormCheckbox
  },
  data() {
    return {
      required,
      validationErrors: '',
      info: '',
      name:'',
      location:'',
     
      id : this.$route.params.id,
    }
  },
  created(){
    //this.getUserDetail();
  },
  methods: {
    validationForm() {
      this.$refs.simpleRules.validate().then(success => {
        if (success) {
          this.validationErrors = '';
          AdminApi.addWarehouseDetail(
            this.info = {
              "name" : this.name,
              "location" : this.location,
             
              "user_id" : this.id,
            },
            data=>{
              if(data.success){
                this.$toast({
                  component: ToastificationContent,
                  props: {
                    title: 'Success!',
                    text: data.message,
                    icon: 'UserIcon',
                    variant: 'success',
                  },
                })
                //router.push({ name: `user-detail/${this.id}` })
              }else{
                if (data.status == 422){
                  this.validationErrors = data.message;
                } else {
                  this.$toast({
                    component: ToastificationContent,
                    props: {
                      title: 'Failed',
                      text: data.message,
                      icon: 'errorIcon',
                      variant: 'outline-danger',
                    },
                  })
                }
              }
            },
            err=>{
              console.log(err);
            }
          )
        }
      })
    },
    getUserDetail(){
        AdminApi.getUserDetail(
            this.id,
            data => {
                this.user = data.data;
                this.first_name = this.user.first_name;
                this.last_name = this.user.last_name;
               
                this.email = this.user.email;
            },
            err => {
                console.log(err);
            }
        );
    }
  },
}
</script>