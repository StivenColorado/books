<template>
    <div class="modal fas" id="category_modal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-hea">
                    <h5 class="modal-title">{{ is_create ? 'crear':'Editar' }} Categoria</h5>
                    <button class="btn-close" type="button" @click="closeModal" aria-label="close">
                    </button>
                </div>

                <backend-error :errors="back_errors"/>

                <Form @submit="saveCategory">
                    <div class="modal-body row">

                        <!-- name -->
                        <div class="col-12">
                            <label for="name">Nombre</label>
                            <Field name="name" v-model="category.name" v-slot="{errorMessage, field}" :rules="name_rules">
                            <input :class="`form-control $errorMessage || back_errors['name'] ? 'in-invalid':'' `" id="name" v-bind="field" />
                            <span class="invalid-feedback">{{ errorMessage }}</span>
                            <span class="invalid-feedback">{{ back_errors['name'] }}</span>

                            </Field>
                        </div>
                    </div>

                    <!-- buttons -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secundary" @click="closeModal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Almacenar</button>
                    </div>
                </Form>
            </div>
        </div>
    </div>

</template>

<script>
import { handlerErrors, successMessage } from "../../helpers/Alerts";
import { ref, getCurrentInstance, handleError } from "vue";
import { Field, Form } from "vee-validate";
import * as yup from "yup";
import backendError from "../Components/BackendError.vue";

export default {
  props: ["category_data"],
  components: { Field, Form, backendError },
  setup({ category_data }) {
    const instance = getCurrentInstance();
    const is_create = category_data ? ref(false) : ref(true);
    const category = !is_create.value ? ref(category_data) : ref({});
    const back_errors = ref({});
    const closeModal = () => instance.parent.ctx.closeModal();

    const saveCategory = async () => {
      try {
        if (is_create.value) {
          await axios.post("/categories", category.value);
        } else {
          await axios.put("/categories/${category.value.id}", category.value);
        }
        successMessage({ is_delete: false, reload: false }).then(() =>
          succesResponse()
        );
      } catch (error) {
        back_errors.value = await handleErrors(error);
      }
    };

    const succesResponse = () => {
      instance.parent.ctx.reloadState();
      closeModal();
    };

    const name_rules = yup.string().required("el nombre es requerido");

    // retorno de data

    return {
      category,
      is_create,
      name_rules,
      back_errors,
      closeModal,
      saveCategory,
    };
  },
};
</script>
