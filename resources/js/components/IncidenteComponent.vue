<template>
    <div>
        <div class="card">
            <Toolbar class="mb-4">
                <template #start>
                    <Button label="Nuevo" icon="pi pi-plus" severity="success" class="mr-2"
                        @click="incidenteDialog = !incidenteDialog ; clearData()" />
                    <!--<Button label="Eliminar" icon="pi pi-trash" severity="danger" @click="confirmDeleteSelected" :disabled="!selectedProducts || !selectedProducts.length" />-->
                </template>

                <template #end>
                    <IconField iconPosition="left">
                        <InputIcon>
                            <i class="pi pi-search" />
                        </InputIcon>
                        <InputText v-model="filters['global'].value" placeholder="Buscar..." />
                    </IconField>
                </template>
            </Toolbar>

            <DataTable ref="dt" :value="incidentes" v-model="search" dataKey="id" :paginator="true" :rows="10"
                :filters="filters"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]"
                currentPageReportTemplate="Mostrando {first} de {last} de {totalRecords} departamentos">
                <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column>
                <Column field="descripcion" header="descripcion" sortable style="min-width: 12rem"></Column>
                <Column field="usuario.apellido" header="usuario" sortable style="min-width: 12rem"></Column>
                <Column :exportable="false">
                    <template #body="slotProps">
                        <Button icon="pi pi-pencil" outlined rounded class="mr-2"
                            @click="setInfoForUpdate(slotProps.data); incidenteDialog = true" />
                        <Button icon="pi pi-trash" outlined rounded severity="danger" class="mr-2"
                            @click="deleteIncidente(slotProps.data.id)" />
                        <Button icon="pi pi-image" outlined rounded severity="info" @click="
                            dataIncidentes = slotProps.data;
                        mostrarImagenDialog = true;
                        " />
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="incidenteDialog" :style="{ width: '650px' }" header="Administrar incidentes"
            :modal="true" class="p-fluid">
            <div class="field">
                <div class="field pb-4">
                    <span>[ Nombre de usuario ] - [ Departamento ]</span>
                </div>
                <div class="formgrid grid row">
                   <!--  <div class="field col-md-6 col-sm-6">

                        <label for="marca">Tipo incidente</label>
                        <Dropdown :options="citizen" optionLabel="label" optionValue="value"
                            placeholder="Seleccione tipo incidente" />
                    </div> -->
                </div>
                <div class="field">
                    <label for="descripcion">Descripcion</label>
                    <Textarea id="descripcion" required="true" rows="2" cols="20" v-model="incidente.descripcion" />
                    <!-- <small class="p-error" v-if="submitted && !producto.descripcion">Descripcion es requerido.</small> -->
                </div>
                <div class="formgrid grid row">
                    <div class="field col">
                        <label for="imagenes">Imágenes</label>
                        <!-- {{ incidente.imagenes }} -->
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="imagenes" multiple accept="image/*"
                                @change="getImages" />
                            <label class="custom-file-label" for="imagenes">Seleccionar archivos...</label>
                        </div>
                    </div>
                </div>
            </div>
            <template #footer>
                <Button label="Cancelar" icon="pi pi-times" text @click="incidenteDialog = false" />
                <Button label="Guardar" icon="pi pi-check" text @click="createIncidente" />
                <Button label="Modificar" icon="pi pi-check" text @click="updateIncidente" />
            </template>
        </Dialog>

        <Dialog v-model:visible="mostrarImagenDialog" :style="{ width: '575px' }" header="Imagenes de productos"
            :modal="true" class="p-fluid">
            <Carousel :value="dataIncidentes.imagenes" :numVisible="1" :numScroll="1" orientation="vertical"
                verticalViewPortHeight="330px" contentClass="flex align-items-center">
                <template #item="slotProps">
                    <div class="border-1 surface-border border-round m-2  p-3">
                        <div class="mb-3">
                            <div class="relative mx-auto">
                                <img :src="slotProps.data.url" :alt="slotProps.data.url"
                                    class="w-full border-round shadow-lg" style="max-height: 330px; max-width: 100%;" />
                            </div>
                        </div>
                    </div>
                </template>
            </Carousel>

        </Dialog>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { FilterMatchMode } from "primevue/api";
import { useToast } from "primevue/usetoast";
import axios from "axios";

export default {
    data() {
        return {
            incidentes: [],
            incidente: {
                id: null,
                descripcion: null,
                usuario_id: null,
                tecnico_id: null,
                estado: null,
                fecha_registro: null,
                created_at: null,
                updated_at: null,
                imagenes: [],
            },
            dataIncidentes: {},
            incidenteDialog: ref(false),
            mostrarImagenDialog: false,
            citizen: [
                { value: "New ", label: "Tipo Incidente 1" },
                { value: "Rome", label: "Tipo Incidente 2" },
                { value: "London", label: "Tipo Incidente 3" },
                { value: "Istanbul", label: "Tipo Incidente 4" },
                { value: "Paris", label: "Tipo Incidente 5" },
            ],
            search: "",
        };
    },
    methods: {
        getImages(event) {
            const files = Array.from(event.target.files); // Convertimos el objeto FileList a un array
            files.forEach((file) => {
                const { name } = file; // Utilizamos destructuring para obtener el nombre del archivo
                this.incidente.imagenes.push({ fileName: name, file }); // Usamos la sintaxis simplificada de objetos
            });
        },

        async getIncidente() {
            await axios.get("/api/incidente").then((response) => {
                console.log(response);
                this.incidentes = response.data;
            });
        },

        async createIncidente() {
            try {
                const formData = new FormData();
                formData.append("descripcion", this.incidente.descripcion);
                // Agregar cada archivo al FormData
                this.incidente.imagenes.forEach((image) => {
                    formData.append("imagenes[]", image.file);
                });
                const resp = await axios.post("/api/incidente", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });

                console.log("Respuesta del servidor:", resp.data);
                this.getIncidente()
                // Aquí puedes manejar la respuesta del servidor como desees
            } catch (error) {
                console.error("Error al subir el archivo:", error);

                // Aquí puedes manejar el error como desees
            }
        },
        async updateIncidente() {
            try {

                const resp = await axios.put(`/api/incidente/${this.incidente.id}`, this.incidente, /* {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                } */);

                console.log("Respuesta del servidor:", resp.data);
                this.getIncidente()

                // Aquí puedes manejar la respuesta del servidor como desees
            } catch (error) {
                console.error("Error al subir el archivo:", error);

                // Aquí puedes manejar el error como desees
            }
        },
        async deleteIncidente(incidenteId) {
            console.log(incidenteId);

            const confirmed = await this.$swal.fire({
                title: 'Seguro/a de eliminar este registro',
                text: 'No se podrá revertir la acción',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí',
                cancelButtonText: 'No'
            });

            if (confirmed.value) {
                try {
                    const response = await this.axios.delete(`/api/incidente/${incidenteId}`);
                    console.log("Estatus: " + response.status);
                    console.log("Data: ", response.data);
                this.getIncidente()

                    // Aquí puedes manejar la respuesta del servidor como desees
                } catch (error) {
                    console.error("Error al eliminar el incidente:", error);
                    // Aquí puedes manejar el error como desees
                }
            }
        },

        clearData() {
            this.incidente.id = ''
            this.incidente.descripcion = ''
            this.incidente.usuario_id = ''
            this.incidente.id = ''
            this.incidente.id = ''
            this.incidente.imagenes = ''

        },
        setInfoForUpdate(data) {
            console.log(data);
            this.incidente.id = data.id;
            this.incidente.descripcion = data.descripcion
            this.incidente.usuario_id = data.id
            this.incidente.id = data.id
            this.incidente.id = data.id
            this.incidente.imagenes = data.imagenes

        }
    },
    mounted() {
        this.getIncidente();
    },
};
</script>
<script setup>
const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});
</script>
