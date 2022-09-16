<template>
  <ul id="main-menu-navigation" class="nav navbar-nav">
    <component
      
      v-for="item in items"
      :key="item.header || item.title"
      :item="item"
      :is="resolveNavComponent(item)"
      v-if="item.gate === undefined || $can(item.gate,'all')"
    />
     
  </ul>
</template>

<script>
import HorizontalNavMenuHeaderLink from "../horizontal-nav-menu-header-link/HorizontalNavMenuHeaderLink.vue";
import HorizontalNavMenuHeaderGroup from "../horizontal-nav-menu-header-group/HorizontalNavMenuHeaderGroup.vue";
import Admin from "../../../../../../../../api/admin";


export default {
  components: {
    HorizontalNavMenuHeaderLink,
    HorizontalNavMenuHeaderGroup
  },
  props: {
    items: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      myItems: [],
      newItmes: []
    };
  },
  created() {
    console.log("in horizental nav comp", this.items);
    this.setUserdata();
    const user = JSON.parse(localStorage.getItem("userData"));
   
     this.getItems(user);
     this.getPermissions(user);
    // this.getPermissionItems();

    
  },
  setup() {
    const resolveNavComponent = item => {
      if (item.children) return "horizontal-nav-menu-header-group";
      return "horizontal-nav-menu-header-link";
    };

    return {
      resolveNavComponent
    };
  },
  methods: {
    setUserdata()
    {
      if(this.$route.params.user)
      {
        console.log('in horizental nav the route params are',this.$route.params.user);
        const userData = JSON.stringify(this.$route.params.user);
        localStorage.setItem('userData', userData);
      }
      
    },
    getItems(user) {
      this.myItems = this.items;
      if(user.user_level_id == 1)
      {
        this.myItems = this.myItems.filter(item => item.header != "Orders" && item.header != "My Orders");
      }
      else if(user.user_level_id == 2)
      {
        this.myItems = this.myItems.filter(item => item.header != "Manage Orders" && item.header != "My Orders" && item.header != "Manage Users");
      }
      else
      {
        this.myItems = this.myItems.filter(item => item.header != "Orders" && item.header != "Manage Orders" && item.header != "Manage Users");
      }
    },
    // getPermissionItems() {
    //   this.myItems = this.items;
    //   const length = this.myItems.length;
    //   for(let i=0; i<length; i++)
    //   {
    //     if(this.$can(this.myItems[i].gate))
    //     {
    //       let j=0;
    //       this.newItmes[j] =  this.myItems[i];
    //       j++;
    //     }
    //   }
    //   console.log('the newitems array is ',this.newItmes);
    // },

      // get permissions for logedin user
    getPermissions(user)
    {
      Admin.getPermissions(
                data => {
                    // this.rows = data.data;
                    console.log('the permissions data is', data.data);
                    this.$ability.update([{action:data.data, subject:'all'
                    }]);
                    //console.log('the ability is', this.$ability);
                    //console.log('in horizental nav the $can parameter is ',this.$can("orders_access",'all'));
                },
                err => {
                    console.log(err);
                },
                user.user_level_id
            );
    }
  }
};
</script>
