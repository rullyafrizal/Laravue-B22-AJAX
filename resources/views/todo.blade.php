<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    <title>To Do List</title>
    <style>
        .completed {
            text-decoration: line-through;
        }
    </style>
</head>
<body>

    <div id="app">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h3>To Do List</h3>
                    <div class="row mb-2">
                        <div class="col-lg-11">
                            <input type="text" class="form-control" v-model="newTodo" @keyup.enter="addTodo">
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-warning" @click="addTodo">Add</button>
                    </div>
                    <ul>
                        <li v-for="(todo, index) in todos" class="my-2">
                            <div class="row justify-content-between">
                                <div class="col-lg-8">
                                    <span :class="{'completed': todo.done}">@{{todo.text}}</span>
                                </div>
                                <div class="col justify-content-end">
                                    <button type="button" class="btn btn-sm btn-danger" @click="removeTodo(index, todo)">Delete</button>
                                    <button type="button" class="btn btn-sm btn-success" @click="toggleComplete(todo)">Done</button>
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
                newTodo: '',
                todos: []
            },
            methods: {
                addTodo(){
                    let textInput = this.newTodo.trim();
                    if(textInput){
                        this.$http.post('/api/todo', {text: textInput}).then(response =>
                            {
                                this.todos.unshift({
                                    text: textInput,
                                    done: 0
                                });
                                this.newTodo = '';
                            }
                        );

                    }
                },
                removeTodo(index, todo){
                    let cf = confirm('Apakah anda yakin?')
                    if(cf) {
                        this.$http.post('/api/todo/delete/' + todo.id).then(response =>
                            {
                                this.todos.splice(index, 1);
                            }
                        );
                    }

                },
                toggleComplete(todo){
                    this.$http.post('/api/todo/update-done-status/' + todo.id).then(response =>
                        {
                            todo.done = !todo.done;
                        }
                    )
                }
            },
            mounted(){
                this.$http.get('/api/todo').then(response =>
                    {
                        this.todos = response.body.data;
                    }
                )
            }
        })
    </script>
</body>
</html>
