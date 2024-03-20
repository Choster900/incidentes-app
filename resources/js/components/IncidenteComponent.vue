<template>
    <div>
        <div class="card">
            <Toolbar class="mb-4">
                <template #start>
                    <Button label="Nuevo" icon="pi pi-plus" severity="success" class="mr-2"
                        @click="incidenteDialog = !incidenteDialog" />
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

            <DataTable ref="dt" :value="departamentos" v-model="search" dataKey="id" :paginator="true" :rows="10"
                :filters="filters"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]"
                currentPageReportTemplate="Mostrando {first} de {last} de {totalRecords} departamentos">
                <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column>
                <Column field="nombre" header="Departamento" sortable style="min-width:12rem"></Column>
                <Column :exportable="false">
                    <template #body="slotProps">
                        <Button icon="pi pi-pencil" outlined rounded class="mr-2"
                            @click="editDepartamento(slotProps.data)" />
                        <Button icon="pi pi-trash" outlined rounded severity="danger"
                            @click="DeleteDepartamento(slotProps.data)" />
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
                    <div class="field col-md-6 col-sm-6">
                        <!-- Aquí estamos especificando que ocupe la mitad del ancho en dispositivos medianos y pequeños -->
                        <label for="marca">Tipo incidente</label>
                        <Dropdown :options="[{ name: 'Australia', code: 'AU' },
                        ]" optionLabel="nombre" optionValue="id" placeholder="Seleccione tipo incidente" />
                        <!--  <small class="p-error" v-if="submitted && !producto.marca_id">Marca es requerido.</small> -->
                    </div>

                </div>
                <div class="field">
                    <label for="descripcion">Descripcion</label>
                    <Textarea id="descripcion" required="true" rows="2" cols="20" />
                    <!-- <small class="p-error" v-if="submitted && !producto.descripcion">Descripcion es requerido.</small> -->
                </div>
                <div class="formgrid grid row">
                    <div class="field col">
                        <label for="imagenes">Imágenes</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="imagenes" multiple accept="image/*">
                            <label class="custom-file-label" for="imagenes">Seleccionar archivos...</label>
                        </div>
                    </div>
                </div>

            </div>
            <template #footer>
                <Button label="Cancelar" icon="pi pi-times" text @click="hideDialog" />
                <Button label="Guardar" icon="pi pi-check" text @click="saveOrUpdate" />
            </template>
        </Dialog>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { FilterMatchMode } from 'primevue/api';
import { useToast } from 'primevue/usetoast';

export default {
    data() {
        return {
            incidentes: [],
            incidente: {
                'id': null,
                'descripcion': null,
                'usuario_id': null,
                'tecnico_id': null,
                'estado': null,
                'fecha_registro': null,
                'created_at': null,
                'updated_at': null,

            },
            incidenteDialog: ref(false)
        }
    },



}

</script>
<script setup>
const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});
</script>
