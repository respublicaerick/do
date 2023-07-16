<template>
  <div>
    <div class="cargando">
      <div class="loader-outter"></div>
      <div class="loader-inner"></div>
    </div>

    <div class="container">
    <p class="title is-1 has-text-weight-bold">
            <b-icon
                icon="tools"
                size="is-large"
                type="personalizado">
            </b-icon>
            Respaldos de la pagina 
    </p>

    <div class="row">
      <span>Elige entre generar el respaldo o aplicar el respaldo al proyecto</span>
    </div>
    <b-button
     style="background-color: orange;"
     icon-left="database"
     @click="backupbase()"
      >Generar Respaldo
    </b-button>

    <div>
    <!-- Resto del código -->
    <input type="file" ref="fileInput" style="display: none" @change="handleFileChange" />
    <b-button
      style="background-color: orange; margin-left: 1000px;"
      icon-left="database"
      @click="openFileInput"
    >Aplicar Respaldo
    </b-button>
    <!-- Resto del código -->
  </div>
        </div>
      </div>
</template>

<script>
import HttpService from "../../Servicios/HttpService";
import { saveAs } from 'file-saver';

export default {
  data() {
    return {
      cargando: false,
    };
  },

  methods: {

    openFileInput() {
      this.$refs.fileInput.click();
    },
    
    handleFileChange(event) {
  const file = event.target.files[0];
  const formData = new FormData();
  formData.append('file', file);

  HttpService.post('restaurar_database.php', formData)
    .then(response => {
      console.log(response.data);
      // Aquí puedes realizar alguna acción con la respuesta del servidor
    })
    .catch(error => {
      console.log(error);
    });
},

backupbase() {
  HttpService.get('backup_base.php')
    .then(response => {
      // Generar el blob con los datos del respaldo
      const blob = new Blob([JSON.stringify(response)], { type: 'application/json' });
      
      // Guardar el archivo en el equipo del usuario
      saveAs(blob, 'respaldo.json');
      
      // Mostrar una notificación de éxito
      const notification = document.createElement('div');
      notification.classList.add('notification');
      notification.textContent = '¡Respaldo generado correctamente!';

      document.body.appendChild(notification);

      setTimeout(() => {
        document.body.removeChild(notification);
      }, 3000);
    })
    .catch(error => {
      console.log(error);
    });
},


  }

}
</script>
<style>
.notification {
  position: fixed;
  top: 10px;
  right: 10px;
  padding: 10px;
  background-color: green;
  color: white;
  font-weight: bold;
  border-radius: 5px;
}
</style>
