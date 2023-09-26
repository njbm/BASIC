<template>
<div class="row">
    <div class="col-sm-6 col-md-4" style=" margin-top:20px;" v-for="(item, index) in items" :key="index">
      <div class="card">
        <img class="card-img-top" :src="item.image" alt="Product" height="400">
        <div class="card-body">
          <h5 class="card-title">{{ item.title}}</h5>
          <p class="card-text">{{ item.caption}}</p>
          <p class="card-text"><strong>Price:</strong>{{ item.price}}</p>
          <a @click="addToCart(item)" class="btn btn-primary">Add to Cart</a> &nbsp;
          <a  class="btn btn-primary">Details</a>
        </div>
      </div>
    </div>
</div>
</template>

<script>

export default{
  props:['items'],
  methods:{
  addToCart(item){
    this.$emit ('newItemAdded',item)
   }
  }
}
</script>

<style></style>