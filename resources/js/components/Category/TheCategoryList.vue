<template>
  <div class="card bg-table">
    <div class="card-header d-flex justify-content-end">
      <button
        type="button"
        class="btn btn-primary btn-custom"
        data-bs-toggle="modal"
        data-bs-target="#exampleModal"
        data-bs-whatever="@getbootstrap"
      >
        Crear categoria
      </button>
    </div>
    <div class="card-body">
      <div class="table-responsive my-4 mx-2">
        <table class="col-12" id="category_table">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody @click="handleAction"></tbody>
        </table>
      </div>
    </div>
  </div>
  <div>
    <!-- modal -->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Crear categoria</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <form @submit="createCategory">
              <div class="mb-3">
                <label for="name" class="col-form-label"
                  >Nombre de categoria</label
                >
                <input type="text" class="form-control bg-dark text-white" name="name" id="name" />
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-bs-dismiss="modal"
                >
                  Close
                </button>
                <button type="button" class="btn btn-primary">
                  Crear categoria
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import CategoryModal from "./CategoryModal.vue";

import {
  successMessage,
  handlerErrors,
  deleteMessage,
} from "../../helpers/Alerts.js";
import HandlerModal from "../../helpers/HandlerModal.js";

export default {
  components: {
    CategoryModal,
  },
  setup(/* props */) {
    const table = ref(null);
    const { openModal, load_modal, closeModal } = HandlerModal();
    const category = ref(null);
    const showModal = ref(false);
    onMounted(() => mounteTable());

    const index = () => mounteTable();

    const mounteTable = () => {
      table.value = $("#category_table").DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        scrollX: true,
        order: [[0, "asc"]],
        autoWidth: false,
        dom: "Bfrtip",
        buttons: ["pageLength", "excel", "pdf", "copy"],
        ajax: `/categories/get-all-dt`,
        columns: [
          { data: "name", name: "name", orderable: true, searchable: true },
          {
            name: "action",
            orderable: false,
            searchable: false,
            render: (data, type, row, meta) => {
              return `<div class="d-flex justify-content-center" data-role="actions">
                        <button onclick="event.preventDefault();" data-id='${row.id}' role='edit' class="btn btn-warning btn-sm" >
                            <i class="fas fa-pencil-alt" data-id='${row.id}' role="edit"></i>
                        </button>

                        <button onclick="event.preventDefault();" data-id='${row.id}' role='delete' class="btn btn-danger btn-sm ms-1" >
                            <i class="fas fa-trash-alt" data-id='${row.id}' role="delete"></i>
                        </button>
                        </div>`;
            },
          },
        ],
      });
    };

    const editCategory = async (id) => {
      try {
        const { data } = await axios.get(`/categories/${id}`);
        category.value = data.category;
        await openModal("category_modal");
      } catch (error) {
        await handlerErrors(error);
      }
    };

    const deleteCategory = async (id) => {
      if (!(await deleteMessage())) return;
      try {
        await axios.delete(`/categories/${id}`);
        await successMessage({ is_delete: true });
        reloadState();
      } catch (error) {
        await handlerErrors(error);
      }
    };

    const reloadState = (event) => {
      table.value.destroy();
      index();
    };

    const handleAction = (event) => {
      const button = event.target;
      const category_id = button.getAttribute("data-id");
      if (button.getAttribute("role") == "edit") {
        editCategory(category_id);
      } else if (button.getAttribute("role") == "delete") {
        deleteCategory(category_id);
      }
    };

    return {
      handleAction,
    //   createCategory,
      load_modal,
      category,
    };
  },
};
</script>
