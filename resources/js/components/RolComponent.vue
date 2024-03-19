
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

            <DataTable ref="dt" :value="roles" v-model="search" dataKey="id"
                :paginator="true" :rows="10" :filters="filters"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5,10,25]"
                currentPageReportTemplate="Mostrando {first} de {last} de {totalRecords} roles">
                <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column>
                <Column field="nombre" header="Rol" sortable style="min-width:12rem"></Column>
                <Column :exportable="false">
                    <template #body="slotProps">
                        <Button icon="pi pi-pencil" outlined rounded class="mr-2" @click="editRol(slotProps.data)" />
                        <Button icon="pi pi-trash" outlined rounded severity="danger" @click="DeleteRol(slotProps.data)" />
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="rolDialog" :style="{width: '450px'}" header="Administración de roles" :modal="true" class="p-fluid">
            <div class="field">
                <label for="name">Nombre</label>
                <InputText id="nombre" v-model.trim="rol.nombre" required="true" autofocus :class="{'p-invalid': submitted && !rol.nombre}" />
                <small class="p-error" v-if="submitted && !rol.nombre">Nombre de rol es requerido.</small>
            </div>
            <template #footer>
                <Button label="Cancelar" icon="pi pi-times" text @click="hideDialog"/>
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
        data(){
           return{
            roles: [],
            rol:{
                id:null,
                nombre:""
            },
            editedRol:-1,
            search:'',
            submitted: false,
            rolDialog: ref(false)
           }
        },
        computed:{
           /* formTitle(){
                return this.categoria.id == null?"Agregar Categoria":"Actualizar Categoria";
            },
            btnTitle(){
                return this.categoria.id == null?"Guardar":"Actualizar";
            }   */        
        },
        methods:{
            async fetchRoles(){
                await this.axios.get(`/api/roles`)
                .then(response => {
                    console.log(response.data);
                    this.roles = response.data;
                })
            },

            openNew(){
                this.rol = {},
                this.submitted = false,
                this.rolDialog = true
            },
            editRol(rol){
                this.rol = {...rol},
                this.rolDialog = true,                
                this.editedRol = this.roles.indexOf(rol);
            },             
            editedRol(rol){
                this.rol = {...rol},
                this.rolDialog = true,                
                this.editedRol = this.roles.indexOf(rol);
            },            

            hideDialog(){
                this.rolDialog = false 
                this.submitted = false                           
            }, 
            async saveOrUpdate(){
                let me = this;
                me.submitted = true;

                if(me.rol.nombre){
                   let accion = me.rol.id == null? "add":"upd";
                   //console.log(accion);
                   if(accion == "add"){
                       //peticion para guardar una rol
                       /*if(this.existCategoria(me.categoria)){
                         alert("Ya existe una categoria registrada con este nombre en la base de datos");
                         return;
                       }*/

                       await this.axios.post(`/api/roles`,me.rol)
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
                    await this.axios.put(`/api/roles/${me.rol.id}`,me.rol)
                       .then(response =>{
                           if(response.status == 202){
                               me.verificarAccion(response.data.data, response.status, accion, response.data.message);
                               me.hideDialog();
                           }
                       }).catch(errors=>{
                        console.log(errors);
                       })                    
                   }
                   me.rolDialog = false;
                   me.rol = {};
                }
            },
            async DeleteRol(rol){
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
                        me.editedRol = me.roles.indexOf(rol);
                        this.axios.delete(`/api/roles/${rol.id}`)
                        .then(response=>{
                            me.verificarAccion(null, response.status,"del",response.data.message);
                        }).catch(errors=>{
                            console.log(errors);
                        })
                    }
                })
            },
            //metodo para verificar sin existe un objeto dentro de un arreglo
            existRol(departamento){
                let me = this;
                return me.roles.some(obj => obj.nombre === rol.nombre);
            },
            verificarAccion(rol, statusCode, accion, message){
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
                        me.roles.unshift(rol);
                        Toast.fire({
                            icon: 'success',
                            title: message
                        });
                        break;
                    case "upd":
                        Object.assign(me.roles[me.editedRol],this.rol);
                        Toast.fire({
                            icon: 'success',
                            title: message
                        });
                        break;   
                    case "del":
                        if(statusCode == 205){
                            me.roles.splice(this.editedRol,1);
                            Toast.fire({
                               icon: 'success',
                               title: "Registro eliminado"
                            });
                        }else{
                            this.$swal.fire({
                               icon: 'error',
                               title: 'No se puede eliminar este rol, existen registros asociados con él.'
                            });
                        }
                        break;                     

                }
            }                        
        },
        mounted() {
            this.fetchRoles();
            console.log('Component mounted.')
        }
    }
      
</script>
<script setup>
    const filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    }); 
</script>
