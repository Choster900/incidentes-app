<template>
  <div class="container">
    <div class="content">
      <div class="image-container">
        <img src="/img/default-prof.png" alt="Logo" class="logo">
      </div>
      <h2>Inicio de sesión</h2>
      <form method="POST" action="{{ route('login') }}">
        <div class="form-group">
          <input v-model="formData.email" placeholder="Correo Electrónico" type="email" id="email" name="email"
            class="form-control" required />
        </div>
        <div class="form-group">
          <input v-model="formData.password" placeholder="Contraseña" type="password" id="password" name="password"
            class="form-control" required />
        </div>
        <button type="submit" class="btn btn-primary">Aceptar</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      formData: {
        email: '',
        password: ''
      },
    }
  },
}
</script>

<style scoped>
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.content {
  background-color: rgba(255, 255, 255, 0.9);
  padding: 10px 80px 30px 80px;
  border-radius: 10px;
  text-align: center;
  max-width: 400px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

.container h2 {
  margin-bottom: 20px;
  color: #333;
}

.form-group {
  margin-bottom: 20px;
}

.form-control {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
}

.btn {
  display: inline-block;
  padding: 10px 20px;
  font-size: 16px;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn-primary {
  background-color: #007bffe0;
  color: #fff;
  border: none;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.image-container {
  text-align: center;
  margin-bottom: 20px;
}

.logo {
  max-width: 150px;
  height: auto;
}
</style>
