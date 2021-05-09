<template>
  <section class="section">
    <div class="container has-background-white">
      <header-welcome></header-welcome>
      <breadcrumb-welcome></breadcrumb-welcome>

      <div class="content content-image">
        <b-loading
          :is-full-page="false"
          v-model="isLoading"
          :can-cancel="true"
        ></b-loading>
        <card-image
          v-for="(file, index) in files"
          :key="'cardImage' + index"
          :filename="file"
        ></card-image>
      </div>
    </div>
  </section>
</template>

<script>
import HeaderWelcome from "../components/HeaderWelcome";
import BreadcrumbWelcome from "../components/BreadcrumbWelcome";
import CardImage from "../components/CardImage";

import http from "../services/s3-http";

export default {
  components: {
    HeaderWelcome,
    BreadcrumbWelcome,
    CardImage,
  },
  data() {
    return {
      isLoading: false,
      files: [],
    };
  },
  methods: {
    getFolder() {
      http
        .get("/files")
        .then((response) => {
          this.files = response.data;
          console.log(this.files);
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => (this.isLoading = false));
    },
  },
  mounted() {
    this.isLoading = true;
    this.getFolder();
  },
};
</script>
