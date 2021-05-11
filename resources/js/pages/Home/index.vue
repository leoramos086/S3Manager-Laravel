<template>
  <section class="section">
    <div class="container has-background-white">
      <header-welcome @refresh="refresh"></header-welcome>
      <breadcrumb-welcome></breadcrumb-welcome>

      <div class="content content-image">
        <b-loading
          :is-full-page="false"
          v-model="isLoading"
          :can-cancel="false"
        ></b-loading>
        <card-image
          v-for="(file, index) in files"
          :key="'cardImage' + index"
          @refresh="refresh"
          :filename="file"
        ></card-image>
        <p class="has-text-centered" v-if="!isLoading && files.length <= 0">
          Empty
        </p>
      </div>
    </div>
  </section>
</template>

<script>
import HeaderWelcome from "./Components/Header";
import BreadcrumbWelcome from "./Components/Breadcrumb";
import CardImage from "./Components/CardImage";

import $http from "../../services/s3-http";

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
      this.isLoading = true;
      this.files = []
      $http
        .get("/files")
        .then((response) => {
          if (!response.data.files) {
            this.$buefy.notification.open({
              message: "Erro na leituras dos arquivos",
              type: "is-danger",
            });
            return;
          }
          this.files = response.data.files;
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => (this.isLoading = false));
    },
    refresh() {
      this.getFolder();
    },
  },
  mounted() {
    this.getFolder();
  },
};
</script>
