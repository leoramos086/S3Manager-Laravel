<template>
  <div class="card">
    <div class="card-image">
      <figure class="image m-0 is-5by3">
        <img
          :src="setUrl(filename)"
          alt="Placeholder image"
        />
      </figure>
    </div>
    <div class="card-content p-3">
      <div class="content">
        <p class="has-text-centered">{{filename}}</p>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  props: {
    filename: {
      type: String,
      required: true
    }
  },
  methods: {
      setUrl(filename){
          return `https://s3-sa-east-1.amazonaws.com/static-dpc.unyleya.com.br/images/${filename}`
      }
  }
};
</script>
