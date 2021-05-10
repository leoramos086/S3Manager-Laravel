<template>
  <div class="content p-5 m-0 has-background-grey-lighter">
    <b-field grouped>
      <b-field class="file is-primary is-lighth">
        <label class="upload control file-label">
          <span class="file-cta">
            <b-icon class="file-icon" icon="upload"></b-icon>
            <span class="file-label">
              {{ isUploading ? "Aguarde" : "Upload" }}
            </span>
          </span>
          <input
            type="file"
            v-on:change="onFileChange"
            accept="image/*"
            :disabled="isUploading"
          />
        </label>
        <!-- <b-button type="is-primary" icon-left="folder">Nova Pasta</b-button> -->
      </b-field>

      <b-field>
        <div class="control">
          <b-button type="is-light" icon-left="redo-alt"></b-button>
        </div>
      </b-field>
    </b-field>
  </div>
</template>

<script>
import { uploadFile } from "../services/s3-http";

export default {
  data() {
    return {
      isUploading: false,
    };
  },
  methods: {
    onFileChange(ev) {
      this.isUploading = true;
      const file = ev.target.files[0];

      if (!file) return (this.isUploading = false);
      const isImage = file.type.match(/^image\/*/) ? true : false;

      if (!isImage)
        return this.$buefy.notification.open({
          message: "Somente imagens são permitidas",
          type: "is-danger",
        });

      uploadFile(file)
        .then((response) => {
          this.$buefy.notification.open({
            message: "Imagem salva com sucesso",
            type: "is-success",
          });
          this.$emit('refresh');
        })
        .catch((error) => {
          this.$buefy.notification.open({
            message: error.response.data,
            type: "is-danger",
          });
        })
        .finally(() => {
          this.isUploading = false;
          ev.target.value = "";
        });
    },
  },
};
</script>
