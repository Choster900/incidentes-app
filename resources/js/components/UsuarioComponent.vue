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

            <DataTable ref="dt" :value="usuarios" v-model="search" dataKey="id" :paginator="true" :rows="10"
                :filters="filters"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]"
                currentPageReportTemplate="Mostrando {first} de {last} de {totalRecords} roles">
                <Column style="width: 3rem" :exportable="false"></Column>
                <Column field="name" header="Usuario" sortable style="min-width:12rem"></Column>
                <Column field="nombres" header="Nombres" sortable style="min-width:12rem"></Column>
                <Column field="apellidos" header="Apellidos" sortable style="min-width:12rem"></Column>
                <Column field="email" header="Correo" sortable style="min-width:12rem"></Column>
                <Column field="rol.nombre" header="Rol" sortable style="min-width:12rem"></Column>
                <Column header="Acciones" :exportable="false">
                    <template #body="slotProps">
                        <Button icon="pi pi-pencil" outlined rounded class="mr-2" @click="editUser(slotProps.data)" />
                        <Button icon="pi pi-trash" outlined rounded severity="danger"
                            @click="deleteUser(slotProps.data)" />
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="rolDialog" :style="{ width: '700px' }" header="Administración de usuarios"
            :modal="true" class="p-fluid">
            <div class="field" style="margin-bottom: 10px; display: flex;">
                <div style="width: 50%; margin-right: 3px;">
                    <label for="name">Usuario</label>
                    <InputText id="name" v-model="user.name" required="true" autofocus
                        :class="{ 'p-invalid': submitted && !user.name }" />
                    <small class="p-error" v-if="submitted && !user.name">Debe ingresar usuario.</small>
                </div>
                <div v-if="user.id == ''" class="field" style="width: 50%; margin-left: 3px;">
                    <label for="name">Contraseña</label>
                    <InputText id="email" type="password" v-model="user.password" required="true" autofocus
                        :class="{ 'p-invalid': submitted && !user.password }" />
                    <small class="p-error" v-if="submitted && !user.password">Debe ingresar contraseña.</small>
                </div>
            </div>

            <div class="field" style="display: flex; margin-bottom: 10px;">
                <div style="width: 50%; margin-right: 3px;">
                    <label for="rol">Rol asignado</label>
                    <Dropdown v-model="user.rol.id" :options="roles" optionLabel="nombre" optionValue="id"
                        placeholder="Seleccione rol" />
                    <small class="p-error" v-if="submitted && !user.rol.id">El rol es requerido.</small>
                </div>
                <div style="width: 50%; margin-left: 3px;">
                    <label for="dep">Departamento</label>
                    <Dropdown v-model="user.departamento.id" :options="departamentos" optionLabel="nombre"
                        optionValue="id" placeholder="Seleccione departamento" />
                    <small class="p-error" v-if="submitted && !user.departamento.id">El departamento es
                        requerido.</small>
                </div>
            </div>

            <div class="field" style="display: flex; margin-bottom: 10px;">
                <div style="width: 50%; margin-right: 3px;">
                    <label for="name">Nombres</label>
                    <InputText id="nombres" v-model="user.nombres" required="true" autofocus
                        :class="{ 'p-invalid': submitted && !user.nombres }" />
                    <small class="p-error" v-if="submitted && !user.nombres">Debe ingresar nombres.</small>
                </div>
                <div style="width: 50%; margin-left: 3px;">
                    <label for="name">Apellidos</label>
                    <InputText id="apellidos" v-model="user.apellidos" required="true" autofocus
                        :class="{ 'p-invalid': submitted && !user.apellidos }" />
                    <small class="p-error" v-if="submitted && !user.apellidos">Debe ingresar nombres.</small>
                </div>
            </div>
            <div class="field" style="margin-bottom: 10px;">
                <div>
                    <label for="name">Email</label>
                    <InputText id="email" type="email" v-model="user.email" required="true" autofocus
                        :class="{ 'p-invalid': submitted && !user.email }" />
                    <small class="p-error" v-if="submitted && !user.email">Debe ingresar email.</small>
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
import { useToast } from "primevue/usetoast";
//const toast = useToast();

export default {
    data() {
        return {
            usuarios: [],
            roles: [],
            departamentos: [],
            user: {
                id: "",
                name: "",
                nombres: "",
                apellidos: "",
                email: "",
                password: "",
                rol: {
                    id: "",
                },
                departamento: {
                    id: ""
                }
            },
            editedRol: -1,
            search: '',
            submitted: false,
            rolDialog: false
        }
    },
    computed: {
        /* formTitle(){
             return this.categoria.id == null?"Agregar Categoria":"Actualizar Categoria";
         },
         btnTitle(){
             return this.categoria.id == null?"Guardar":"Actualizar";
         }   */
    },
    methods: {
        async fetchUsers() {
            await this.axios.get(`/api/users`)
                .then(response => {
                    this.usuarios = response.data;
                })
        },
        async fetchRoles() {
            await this.axios.get(`/api/roles`)
                .then(response => {
                    this.roles = response.data;
                })
        },
        async fetchDepartamentos() {
            await this.axios.get(`/api/departamentos`)
                .then(response => {
                    this.departamentos = response.data;
                })
        },

        openNew() {
            this.user.id = ''
            this.user.name = ''
            this.user.nombres = ''
            this.user.apellidos = ''
            this.user.email = ''
            this.user.rol.id = ''
            this.user.departamento.id = ''
            this.submitted = false
            this.rolDialog = true
        },
        editUser(user) {
            this.user = { ...user }
            this.rolDialog = true
        },
        hideDialog() {
            this.rolDialog = false
            this.submitted = false
        },
        async saveOrUpdate() {
            let me = this;
            me.submitted = true;

            const Toast = this.$swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });

            if (me.user.id == '') {
                //peticion para guardar una rol
                if (me.usuarios.some(obj => obj.name === me.user.name)) {
                    alert("Ya existe un usuario registrado con ese nombre de usuario.");
                    return;
                }

                await this.axios.post(`/api/users`, me.user)
                    .then(response => {
                        Toast.fire({
                            icon: 'success',
                            title: response.data.message
                        });
                        this.fetchUsers();
                    }).catch(errors => {
                        Toast.fire({
                            icon: 'error',
                            title: errors.response.data.message
                        });
                    })
            } else {

                if (me.usuarios.some(obj => obj.name === me.user.name && obj.id !== me.user.id)) {
                    alert("Ya existe un usuario registrado con ese nombre de usuario.");
                    return;
                }
                //peticion para actualizar usuarios
                await this.axios.put(`/api/users/${me.user.id}`, me.user)
                    .then(response => {
                        Toast.fire({
                            icon: 'success',
                            title: response.data.message
                        });
                        this.fetchUsers();
                    }).catch(errors => {
                        Toast.fire({
                            icon: 'error',
                            title: errors.response.data.message
                        });
                    })
            }
            me.rolDialog = false;

        },
        async deleteUser(user) {
            let me = this;

            const Toast = this.$swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });

            this.$swal.fire({
                title: 'Seguro/a de eliminar este registro',
                text: 'No se podrá revertir la acción',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    this.axios.delete(`/api/users/${user.id}`)
                        .then(response => {
                            console.log(response);
                            if (response.data.status == 'Deleted') {
                                Toast.fire({
                                    icon: 'success',
                                    title: response.data.message
                                });
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: response.data.message
                                });
                            }
                            this.fetchUsers()
                        }).catch(errors => {
                            console.log(errors);
                        })
                }
            })
        },
        //metodo para verificar sin existe un objeto dentro de un arreglo
        // existUser(user) {
        //     let me = this;
        //     return me.usuarios.some(obj => obj.name === user.name);
        // },
        verificarAccion(rol, statusCode, accion, message) {
            let me = this;
            const Toast = this.$swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });

            switch (accion) {
                case "add":
                    me.roles.unshift(rol);
                    Toast.fire({
                        icon: 'success',
                        title: message
                    });
                    break;
                case "upd":
                    Object.assign(me.roles[me.editedRol], this.rol);
                    Toast.fire({
                        icon: 'success',
                        title: message
                    });
                    break;
                case "del":
                    if (statusCode == 205) {
                        me.roles.splice(this.editedRol, 1);
                        Toast.fire({
                            icon: 'success',
                            title: "Registro eliminado"
                        });
                    } else {
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
        this.fetchUsers();
        this.fetchRoles();
        this.fetchDepartamentos()
        console.log('Component mounted.')
    }
}

</script>
<script setup>
const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
}); 
</script>
