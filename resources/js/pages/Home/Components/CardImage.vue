<template>
  <div class="card">
    <div class="card-buttons">
      <b-button
        size="is-small"
        type="is-light"
        icon-left="trash"
        title="Deletar"
        @click.prevent="deleteItem()"
      ></b-button>
      <b-button
        size="is-small"
        type="is-light"
        icon-left="copy"
        title="Copiar Link"
        v-clipboard:copy="url"
        v-clipboard:success="onCopy"
      ></b-button>
      <b-button
        size="is-small"
        type="is-light"
        icon-left="download"
        title="Download"
        tag="a"
        target="_blank"
        :href="downloadUrl()"
      ></b-button>
      <b-button
        tag="a"
        size="is-small"
        :href="url"
        target="_blank"
        type="is-light"
        title="Abrir"
        icon-left="external-link-alt"
      ></b-button>
    </div>

    <div class="card-image">
      <figure class="image m-2 is-5by3">
        <img :src="url" alt="Placeholder image" />
      </figure>
    </div>
    <div class="card-content">
      <div class="content">
        <p>{{ filename }}</p>
      </div>
    </div>
  </div>
</template>


<script>
import { deleteItem } from "../../../services/s3-http";

export default {
  props: {
    filename: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      url: "",
    };
  },
  methods: {
    deleteItem() {
      deleteItem(this.filename)
      .then((response) => {
          if (response.data.ok) {
              console.log(response)
            this.$buefy.notification.open({
              message: "Imagem salva com sucesso",
              type: "is-success",
            });
            this.refresh();
          }
        });
    },
    downloadUrl() {
      return `${window.Laravel.baseUrl}/download?path=${encodeURI(
        this.$props.filename
      )}`;
    },
    onCopy() {
      this.$buefy.notification.open({
        message: "Link Copiado!",
        type: "is-success",
        duration: 1000,
      });
    },
    refresh() {
      this.$emit("refresh");
    }
  },
  mounted() {
    this.url = `https://s3-sa-east-1.amazonaws.com/static-dpc.unyleya.com.br/images/${this.$props.filename}`;
  },
};
</script>

<style scoped lang="scss">
.card {
  border: 1px solid #ddd;
  border-radius: 0;
  transition: all 2s ease-in-out;
  overflow: hidden;

  &:hover {
    .card-image {
      //   filter: brightness(0.8);
    }
    .card-buttons {
      transform: translateY(0);
      opacity: 1;
    }
  }

  .card-content {
    padding: 0.5rem;
  }

  .card-buttons {
    position: absolute;
    top: 0px;
    left: 0;
    width: 100%;
    height: 40px;
    display: flex;
    justify-content: flex-end;
    align-items: center;

    background-color: rgba(black, 0.4);
    transition: all 0.2s ease-in-out;
    opacity: 0;
    transform: translateY(-100%);
    z-index: 99;
    padding: 0 4px;

    .button {
      margin: 0 3px;
    }
  }

  .card-content {
    .content {
      p {
        text-align: center;
        font-size: 0.9rem;
      }
    }
  }
}
</style>
