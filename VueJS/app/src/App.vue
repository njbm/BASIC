<template>
<div class="" id="app">
  <NavMenu @search="search"/>
  <div class="row d">
    <div class="col-sm-9"><Products @newItemAdded="addCartItem" :items="items"/></div>
    <div class="col-sm-3"><Cart @itemRemoved="removeItem" :items="cart"/></div>
  </div>
</div>
</template>

<script>
import Cart from './components/Cart.vue';
import NavMenu from './components/NavMenu.vue';
import Products from './components/Products.vue';
import data from './data';

export default {
  components: { NavMenu, Products, Cart },
  data(){
    return{
      items: [], 
      cart: []
    }
  },
  mounted(){
    this.items= data
  },
  methods: {
    addCartItem(item){
      this.cart.push(item)
    },
    removeItem(index){
      this.cart.splice(index, 1)
    },
    search(keyword){
      this.items = data.filter(item=>{
        return item.title.toLocaleLowerCase().indexOf(keyword.toLocaleLowerCase()) !== -1
      })
    }
  },
  

}
</script>

<style>
.d{ padding: 20px;; }
</style>
