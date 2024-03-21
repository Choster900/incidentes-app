
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

            <DataTable ref="dt" :value="departamentos" v-model="search" dataKey="id"
                :paginator="true" :rows="10" :filters="filters"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5,10,25]"
                currentPageReportTemplate="Mostrando {first} de {last} de {totalRecords} departamentos">
                <Column style="width: 3rem" :exportable="false"></Column>
                <Column field="nombre" header="Departamento" sortable style="min-width:12rem"></Column>
                <Column :exportable="false">
                    <template #body="slotProps">
                        <Button icon="pi pi-pencil" outlined rounded class="mr-2" @click="editDepartamento(slotProps.data)" />
                        <Button icon="pi pi-trash" outlined rounded severity="danger" @click="DeleteDepartamento(slotProps.data)" />
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="departamentoDialog" :style="{width: '450px'}" header="Administración de departamentos" :modal="true" class="p-fluid">
            <div class="field">
                <label for="name">Nombre</label>
                <InputText id="nombre" v-model.trim="departamento.nombre" required="true" autofocus :class="{'p-invalid': submitted && !departamento.nombre}" />
                <small class="p-error" v-if="submitted && !departamento.nombre">Nombre de departamento es requerido.</small>
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
            departamentos: [],
            departamento:{
                id:null,
                nombre:""
            },
            editedDepartamento:-1,
            search:'',
            submitted: false,
            departamentoDialog: ref(false)
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
            async fetchDepartamentos(){
                await this.axios.get(`/api/departamentos`)
                .then(response => {
                    console.log(response.data);
                    this.departamentos = response.data;
                })
            },

            openNew(){
                this.departamento = {},
                this.submitted = false,
                this.departamentoDialog = true
            },
            editDepartamento(departamento){
                this.departamento = {...departamento},
                this.departamentoDialog = true,                
                this.editedDepartamento = this.departamentos.indexOf(departamento);
            },             
            editedDepartamento(departamento){
                this.departamento = {...departamento},
                this.departamentoDialog = true,                
                this.editedDepartamento = this.departamentos.indexOf(departamento);
            },            

            hideDialog(){
                this.departamentoDialog = false 
                this.submitted = false                           
            }, 
            async saveOrUpdate(){
                let me = this;
                me.submitted = true;

                if(me.departamento.nombre){
                   let accion = me.departamento.id == null? "add":"upd";
                   //console.log(accion);
                   if(accion == "add"){
                       //peticion para guardar una marca
                       if(this.existDepartamento(me.departamento)){
                         alert("Ya existe un departamento registrado con este nombre en la base de datos");
                         return;
                       }

                       await this.axios.post(`/api/departamentos`,me.departamento)
                       .then(response =>{
                           if(response.status == 201){
                               me.verificarAccion(response.data.data, response.status, accion, response.data.message);
                           }
                       }).catch(errors=>{
                        console.log(errors);
                       })
                   }else{

                    if(this.existDepartamento(me.departamento)){
                         alert("Ya existe un departamento registrado con este nombre en la base de datos");
                         return;
                       }                    
                    //peticion para actualizar marcas
                    await this.axios.put(`/api/departamentos/${me.departamento.id}`,me.departamento)
                       .then(response =>{
                           if(response.status == 202){
                               me.verificarAccion(response.data.data, response.status, accion, response.data.message);
                               me.hideDialog();
                           }
                       }).catch(errors=>{
                        console.log(errors);
                       })                    
                   }
                   me.departamentoDialog = false;
                   me.departamento = {};
                }
            },
            async DeleteDepartamento(departamento){
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
                        me.editedDepartamento = me.departamentos.indexOf(departamento);
                        this.axios.delete(`/api/departamentos/${departamento.id}`)
                        .then(response=>{
                            me.verificarAccion(null, response.status,"del",response.data.message);
                        }).catch(errors=>{
                            console.log(errors);
                        })
                    }
                })
            },
            //metodo para verificar sin existe un objeto dentro de un arreglo
            existDepartamento(departamento){
                let me = this;
                return me.departamentos.some(obj => obj.nombre === departamento.nombre);
            },
            verificarAccion(departamento, statusCode, accion, message){
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
                        me.departamentos.unshift(departamento);
                        Toast.fire({
                            icon: 'success',
                            title: message
                        });
                        break;
                    case "upd":
                        Object.assign(me.departamentos[me.editedDepartamento],this.departamento);
                        Toast.fire({
                            icon: 'success',
                            title: message
                        });
                        break;   
                    case "del":
                        if(statusCode == 205){
                            me.departamentos.splice(this.editedDepartamento,1);
                            Toast.fire({
                               icon: 'success',
                               title: "Registro eliminado"
                            });
                        }else{
                            this.$swal.fire({
                               icon: 'error',
                               title: 'No se puede eliminar esta departamento, existen registros asociados con él.'
                            });
                        }
                        break;                     

                }
            }                        
        },
        mounted() {
            this.fetchDepartamentos();
            console.log('Component mounted.')
        }
    }
      
</script>
<script setup>
    const filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    }); 
</script>
