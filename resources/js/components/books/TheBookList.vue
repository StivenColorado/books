<template>
  <section>
    <div class="card bg-table">
      <div class="card-header d-flex justify-content-end">
        <button class="btn btn-primary btn-custom" @click="openModal">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="20"
            height="20"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-bookmark"
          >
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M18 7v14l-6 -4l-6 4v-14a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4z" />
          </svg>

          <span> Crear libro </span>
        </button>
      </div>
      <div class="card-body bg-table" >
        <div class="table-responsive my-4 mx-2">
          <table class="col-12 bg-table" id="book_table">
            <thead style="height: 3em">
              <tr>
                <th>Titulo</th>
                <th>Autor</th>
                <th>Categoria</th>
                <th>Cantidad</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(book, index) in books"
                :key="index"
                class="bg-custom-row"
                style="height: 3em"
              >
                <td>{{ book.title }}</td>
                <td>{{ book.author.name }}</td>
                <td>{{ book.category.name }}</td>
                <td>{{ book.stock }}</td>
                <td>
                  <div class="d-flex justify-content-center" title="Editar">
                    <button
                      type="button"
                      class="btn btn-warning btn-sm"
                      @click="editBook(book)"
                    >
                      <i class="fas fa-pencil-alt"></i>
                    </button>
                    <button
                      type="button"
                      class="btn btn-danger btn-sm ms-2"
                      title="Eliminar"
                      @click="deletBook(book)"
                    >
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div>
        <book-modal
          :authors_data="authors_data"
          :book_data="book"
          ref="book_modal"
        />
      </div>
    </div>
  </section>
</template>

<script>
import BookModal from "./BookModal.vue";
import { deleteMessage, successMessage } from "../../helpers/Alerts";

export default {
  components: {
    BookModal,
  },
  props: ["books", "authors_data"],
  data() {
    return {
      modal: null,
      book: {},
    };
  },
  mounted() {
    this.index();
  },
  methods: {
    async index() {
      $("#book_table").DataTable();
      const modal_id = document.getElementById("book_modal");
      this.modal = new bootstrap.Modal(modal_id);
      modal_id.addEventListener("hidden.bs.modal", (e) => {
        this.$refs.book_modal.reset();
      });
    },
    editBook(book) {
      this.book = book;
      this.openModal();
    },
    async deletBook({ id }) {
      if (!(await deleteMessage())) return;
      try {
        await axios.delete(`/books/${id}`);
        await successMessage({ is_delete: true, reload: true });
      } catch (error) {
        console.error(error);
      }
    },
    openModal() {
      this.modal.show();
    },
  },
};
</script>

