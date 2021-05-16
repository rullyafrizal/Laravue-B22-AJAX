<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD Name List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
</head>
<body>
    <div id="app">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h3>Name List</h3>
                    <div class="input-group">
                        <div class="flex-fill">
                            <input type="text" class="form-control" v-model="newName" placeholder="Masukkan Nama..." @keyup.enter="addName">
                        </div>
                        <div class="input-group-append">
                            <button type="button" class="flex-fill btn btn-sm btn-success" @click="addName" v-show="!updateSubmit">Add</button>
                            <button type="button" class="flex-fill btn btn-sm btn-success" @click="updateName(names[selectedNameIndex])" v-show="updateSubmit">Update</button>
                        </div>
                    </div>
                    <ul class="list-group my-3">
                        <li class="list-group-item" v-for="(name, index) in names">
                            <div class="row justify-content-between">
                                <div class="col-lg-9">
                                    <span>@{{ name.name }}</span>
                                </div>
                                <div class="col justify-content-end">
                                    <button class="btn btn-sm btn-primary" @click="editName(name, index)"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger" @click="deleteName(name, index)"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>
<script>
    new Vue({
        el: '#app',
        data: {
            newName: '',
            names: [],
            selectedNameIndex: null,
            updateSubmit: false
        },
        methods: {
            addName(){
                let nameInput = this.newName.trim();
                if(nameInput){
                    this.$http.post('/api/crud-name', {name: nameInput})
                        .then(response => {
                            this.names.unshift({
                                name: nameInput
                            });
                            this.newName = '';
                            window.location.reload();
                        });
                }
            },
            editName(paramName, index){
                this.selectedNameIndex = index;
                this.updateSubmit = true;
                this.newName = paramName.name;
            },
            updateName(name){
                let nameInput = this.newName.trim();
                this.$http.post(`api/crud-name/update/${name.id}`, {name: nameInput})
                    .then(response => {
                        this.names[this.selectedNameIndex].name = nameInput;
                        this.newName = '';
                        this.updateSubmit = false;
                        this.selectedNameIndex = null;
                    });
            },
            deleteName(name, index){
                let cf = confirm('Apakah anda yakin?');
                if(cf){
                    this.$http.post('api/crud-name/delete/' + name.id).then(response => {
                        this.names.splice(index, 1);
                    });
                }
            }
        },
        mounted(){
            this.$http.get('/api/crud-name').then(response =>
                {
                    this.names = response.body.data;
                }
            )
        }
    });
</script>
</body>
</html>
