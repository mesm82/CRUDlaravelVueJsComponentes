<template>
<div>
 
 <form @submit.prevent="editarDato(dato)" v-if="editarActivo">
  <h3>Editar Datos</h3>
     <input type="number" v-model="dato.cedula" placeholder="Cédula" class="form-control mb-2">
     <input type="text" v-model="dato.nombre" placeholder="Nombre" class="form-control mb-2">
     <select v-model="dato.sexo" class="form-control mb-2">
         <option value="">Seleccione...</option>
         <option value="Femenino">Femenino</option>
         <option value="Masculino">Masculino</option>
     </select>
     <input type="date" v-model="dato.fecha_n" class="form-control mb-2">
     <button class="btn btn-success" type="submit">Editar</button>
     <button class="btn btn-danger" type="submit" @click="cancelarEdicion()" >Cancelar</button>
 </form>
 <form @submit.prevent="agregar" v-else>
     <h3>Agregar Datos</h3>
     <input type="number" v-model="dato.cedula" placeholder="Cédula" class="form-control mb-2">
     <input type="text" v-model="dato.nombre" placeholder="Nombre" class="form-control mb-2">
     <select v-model="dato.sexo" class="form-control mb-2">
         <option value="">Seleccione...</option>
         <option value="Femenino">Femenino</option>
         <option value="Masculino">Masculino</option>
     </select>
     <input type="date" v-model="dato.fecha_n" class="form-control mb-2">
     <button class="btn btn-primary" type="submit">Agregar</button>
 </form>
 <hr class="mt-3">
 <h3>Listado de Personas</h3>
 <ul class="list-group my-2">
     <li class="list-group-item" v-for="(item, index) in datos" :key="index">
         <span class="badge badge-primary float-right">
            {{item.updated_at}}
          </span>
          <p>{{item.cedula}}</p>
          <p>{{item.nombre}}</p>
          <p>{{item.sexo}}</p>
          <p>{{item.fecha_n}}</p>
          <p>
            <button class="btn btn-warning btn-sm" 
                @click="editar(item)">Editar</button>
            <button class="btn btn-danger btn-sm" 
                @click="eliminar(item, index)">Eliminar</button>
          </p>
     </li>
 </ul>
</div>
</template>

<script>
export default{
    data(){
        return{
            datos: [],
            dato:{cedula:'', nombre:'', sexo:'', fecha_n:''},
            editarActivo:false
        }
    },
    created(){
    axios.get('/crudLaravel/public/datos')
    .then(res=>{
      this.datos = res.data;
    })
   },
    methods:{
        agregar(){
            if((this.dato.cedula.trim()==="")||(this.dato.nombre.trim()==="")||(this.dato.sexo.trim()==="")||(this.dato.fecha_n.trim()===""))
            {
                alert("Todos los campos son obligatorios");
                return;
            }
            //console.log(this.dato.cedula,this.dato.nombre,this.dato.sexo,this.dato.fecha_n);
            const params={cedula:this.dato.cedula,nombre:this.dato.nombre,sexo:this.dato.sexo,fecha_n:this.dato.fecha_n};
            this.dato.cedula='';
            this.dato.nombre='';
            this.dato.sexo="";
            this.dato.fecha_n="";

            axios.post('/crudLaravel/public/datos', params)
               .then(res => {
                    this.datos.push(res.data)
               })
        },
        editar(item){
            this.editarActivo=true;
            this.dato.cedula=item.cedula;
            this.dato.nombre=item.nombre;
            this.dato.sexo=item.sexo;
            this.dato.fecha_n=item.fecha_n;
            this.dato.id=item.id;
        },
        editarDato(item){
            const params={cedula:item.cedula,nombre:item.nombre,sexo:item.sexo,fecha_n:item.fecha_n};
            this.editarActivo=false;
            axios.put(`/crudLaravel/public/datos/${item.id}`, params)
            .then(res=> {
                const index=this.datos.findIndex(datoBuscar=>datoBuscar.id===res.data.id)
                this.datos[index]=res.data;
                 this.dato={cedula:'', nombre:'', sexo:'', fecha_n:''}
                 axios.get('/crudLaravel/public/datos')
                  .then(res=>{
                 this.datos = res.data;
                })
            })
        },
        cancelarEdicion(){
            this.editarActivo=false;
            this.dato={cedula:'', nombre:'', sexo:'', fecha_n:''}
        },
        eliminar(item,index){
        const confirmacion = confirm(`Desea eliminar a ${item.nombre}`);
        if(confirmacion){
            axios.delete(`/crudLaravel/public/datos/${item.id}`)
            .then(() => {
                this.datos.splice(index,1);
            })
         }
        } 
    }     
}

</script>
