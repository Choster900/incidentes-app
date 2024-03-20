
<template>
    <div>
        <div class="card">
            <Toolbar class="mb-4">
                <template #start>
                    <Button label="Nuevo" icon="pi pi-plus" severity="success" class="mr-2" @click="openNew" />
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

            <DataTable ref="dt" :value="permisos" v-model="search" dataKey="id"
                :paginator="true" :rows="10" :filters="filters"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5,10,25]"
                currentPageReportTemplate="Mostrando {first} de {last} de {totalRecords} permisos">
                <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column>
                <Column field="nombre" header="Rol" sortable style="min-width:12rem"></Column>
                <Column :exportable="false">
                    <template #body="slotProps">
                        <Button icon="pi pi-pencil" outlined rounded class="mr-2" @click="editPermiso(slotProps.data)" />
                        <Button icon="pi pi-trash" outlined rounded severity="danger" @click="DeletePermiso(slotProps.data)" />
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="permisoDialog" :style="{width: '450px'}" header="Administración de permisos" :modal="true" class="p-fluid">
            <div class="field">
                <label for="name">Nombre</label>
                <InputText id="nombre" v-model.trim="permiso.nombre" required="true" autofocus :class="{'p-invalid': submitted && !permiso.nombre}" />
                <small class="p-error" v-if="submitted && !permiso.nombre">Nombre de permiso es requerido.</small>
            </div>
            <div class="field">
                <label for="ruta">Ruta</label>
                <InputText id="ruta" v-model.trim="permiso.ruta" required="true" autofocus :class="{'p-invalid': submitted && !permiso.ruta}" />
                <small class="p-error" v-if="submitted && !permiso.ruta">Ruta es requerido.</small>
            </div> 
            <div class="card flex flex-wrap justify-content-center gap-3">
                <div class="card flex flex-wrap justify-content-center gap-3">
                    <div class="flex align-items-center">
                        <Checkbox v-model="opciones" inputId="agregar" name="opciones" value="add" />
                        <label for="ingredient1" class="ml-2"> Agregar </label>
                    </div>
                    <div class="flex align-items-center">
                        <Checkbox v-model="opciones" inputId="editar" name="opciones" value="upd" />
                        <label for="ingredient2" class="ml-2"> Editar </label>
                    </div>
                    <div class="flex align-items-center">
                        <Checkbox v-model="opciones" inputId="listar" name="opciones" value="sho" />
                        <label for="ingredient3" class="ml-2"> Listar </label>
                    </div>
                    <div class="flex align-items-center">
                        <Checkbox v-model="opciones" inputId="eliminar" name="opciones" value="del" />
                        <label for="ingredient4" class="ml-2"> Eliminar </label>
                    </div>
                </div>   
                {{ opciones }}             
            </div>                         
            <template #footer>
                <Button label="Cancelar" icon="pi pi-times" text @click="hideDialog"/>
                <Button label="Guardar" icon="pi pi-check" text @click="probar" />
            </template>
        </Dialog>
	</div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { FilterMatchMode } from 'primevue/api';
import { useToast } from 'primevue/usetoast';

export default {
        data(){
           return{
            permisos: [],
            permiso:{
                id:null,
                nombre:"",
                agregar:this.getAgregar,
                editar:ref(true),
                listar:ref(true),
                eliminar:ref(true)
            },
            opciones:[],
            editedPermiso:-1,
            search:'',
            submitted: false,
            permisoDialog: ref(false)
           }
        },
        computed:{  
            getAgregar(){
                return this.opciones.indexOf('add') == -1?true:false;
            }    
        },
        methods:{
            async fetchPermisos(){
                await this.axios.get(`/api/permisos`)
                .then(response => {
                    console.log(response.data);
                    this.permisos = response.data;
                })
            },

            openNew(){
                this.permiso = {},
                this.submitted = false,
                this.permisoDialog = true
            },
            probar(){
                //this.permiso.agregar = this.checked,            
                console.log(this.permiso.agregar),
                this.submitted = true,
                this.permisoDialog = false
            },            
            editPermiso(permiso){
                this.permiso = {...rol},
                this.permisoDialog = true,                
                this.editedPermiso = this.permisos.indexOf(permiso);
            },             
            editedPermiso(permiso){
                this.permiso = {...permiso},
                this.permisoDialog = true,                
                this.editedPermiso = this.permisos.indexOf(permiso);
            },            

            hideDialog(){
                this.permisoDialog = false 
                this.submitted = false                           
            }, 
            async saveOrUpdate(){
                let me = this;
                me.submitted = true;

                if(me.permiso.nombre){
                   let accion = me.permiso.id == null? "add":"upd";
                   //console.log(accion);
                   if(accion == "add"){
                       //peticion para guardar una rol
                       /*if(this.existCategoria(me.categoria)){
                         alert("Ya existe una categoria registrada con este nombre en la base de datos");
                         return;
                       }*/

                       await this.axios.post(`/api/permisos`,me.permiso)
                       .then(response =>{
                           if(response.status == 201){
                               me.verificarAccion(response.data.data, response.status, accion, response.data.message);
                           }
                       }).catch(errors=>{
                        console.log(errors);
                       })
                   }else{

                    /*if(this.existMarca(me.marca)){
                         alert("Ya existe una marca registrada con este nombre en la base de datos");
                         return;
                       }*/                    
                    //peticion para actualizar marcas
                    await this.axios.put(`/api/permisos/${me.permiso.id}`,me.permiso)
                       .then(response =>{
                           if(response.status == 202){
                               me.verificarAccion(response.data.data, response.status, accion, response.data.message);
                               me.hideDialog();
                           }
                       }).catch(errors=>{
                        console.log(errors);
                       })                    
                   }
                   me.permisoDialog = false;
                   me.permiso = {};
                }
            },
            async DeletePermiso(permiso){
                let me = this;
                
                this.$swal.fire({
                    title: 'Seguro/a de eliminar este registro',
                    text: 'No se podrá revertir la acción',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No'
                }).then((result)=>{
                    if(result.value){
                        me.editedPermiso = me.permisos.indexOf(permiso);
                        this.axios.delete(`/api/permisos/${permiso.id}`)
                        .then(response=>{
                            me.verificarAccion(null, response.status,"del",response.data.message);
                        }).catch(errors=>{
                            console.log(errors);
                        })
                    }
                })
            },
            //metodo para verificar sin existe un objeto dentro de un arreglo
            existPermiso(permiso){
                let me = this;
                return me.permisos.some(obj => obj.nombre === permiso.nombre);
            },
            verificarAccion(permiso, statusCode, accion, message){
                let me = this;
                const Toast = this.$swal.mixin({
                    toast: true,
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });

                switch(accion){
                    case "add":
                        me.permisos.unshift(permiso);
                        Toast.fire({
                            icon: 'success',
                            title: message
                        });
                        break;
                    case "upd":
                        Object.assign(me.permisos[me.editedPermiso],this.permiso);
                        Toast.fire({
                            icon: 'success',
                            title: message
                        });
                        break;   
                    case "del":
                        if(statusCode == 205){
                            me.permisos.splice(this.editedPermiso,1);
                            Toast.fire({
                               icon: 'success',
                               title: "Registro eliminado"
                            });
                        }else{
                            this.$swal.fire({
                               icon: 'error',
                               title: 'No se puede eliminar este permiso, existen registros asociados con él.'
                            });
                        }
                        break;                     

                }
            }                        
        },
        mounted() {
            this.fetchPermisos();
            console.log('Component mounted.')
        }
    }
      
</script>
<script setup>
//import { ref } from "vue";

    //const opciones = ref();
    const filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    }); 
</script>
