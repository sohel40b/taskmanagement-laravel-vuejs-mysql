<template>
    <section class="vh-100" style="background-color: #eee;">
        <div class="container py-5 h-50">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-8">
                    <h2 class="mb-4"> Task List </h2>
                    <p class="text-success" v-if="messages">{{ messages }}</p>
                    <p class="text-danger" v-if="error">{{ error }}</p>
                    <form @submit.prevent="insertTasks" class="d-flex justify-content-center align-items-center mb-4">
                        <div class="form-outline flex-fill me-3">
                            <input type="text" class="form-control" placeholder="Add Title" v-model="form.title"/>
                        </div>
                        <div class="form-outline flex-fill">
                            <textarea class="form-control" id="textAreaExample1" rows="1" v-model="form.description" placeholder="Enter Task Descriptions here..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-info ms-2">Add</button>
                    </form>
                    
                    <div class="card">
                        <div class="card-header p-3">
                            <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Task List</h5>
                        </div>
                        <div class="d-flex justify-content-end align-items-center mb-4 pt-2 pb-4">
                            <p class="small mb-0 me-2 text-muted"><label for="status">Select Status:</label></p>
                            <select class="select" v-model="selectedStatus" @change="fetchTasksByStatus">
                                <option value="">All</option>
                                <option value="2">Incomplete</option>
                                <option value="1">Completed</option>
                            </select>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#ID</th>
                                        <th scope="col">Task Name</th>
                                        <th scope="col">Descriptions</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="fw-normal" v-for="task in tasks" :key="task">
                                        <th>
                                            <span>{{task.id}}</span>
                                        </th>
                                        <td class="align-middle">
                                            <p>{{task.title}}</p>
                                        </td>
                                        <td class="align-middle">
                                            <p>{{task.description}}</p>
                                        </td>
                                        <td>
                                            <p>{{task.status}}</p>
                                        </td>
                                        <td class="align-middle">
                                            <button class="btn btn-success me-2" @click="updateTasks(task.id)">Complete</button>
                                            <button class="btn btn-danger" @click="deleteTasks(task.id)">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { reactive,ref,toRefs } from 'vue'
import { useRouter } from "vue-router"
import { UserStore } from '@/store/UserStore.js'
export default{
    setup(){
        const router = useRouter()
        const store = UserStore();
        let form = reactive({
            title: '',
            description: '',
        });
        let error = ref('')
        let messages = ref('')
        const selectedStatus = ref('')
        const state = reactive({
            tasks: [],
        })
        const fetchTasksByStatus = async () => {
            const apiUrl = selectedStatus.value
            ? `/api/tasks/by/${selectedStatus.value}`
            : '/api/tasks/by';
          
            const response = await axios.get(apiUrl,{
                headers: {
                    'Authorization': `Bearer ${store.getToken}`,
                },
            });
            state.tasks = response.data.tasks;
        }
        const fetchTasks = async () => {
            const response = await axios.get('/api/tasks',{
                headers: {
                    'Authorization': `Bearer ${store.getToken}`,
                },
            });
            state.tasks = response.data.tasks;
        }
        fetchTasks();
        const insertTasks = async() =>{
            await axios.post('/api/tasks',form,{
                headers: {
                    'Authorization': `Bearer ${store.getToken}`,
                },
            }).then(res=>{
                if(res.data.status == true){
                    fetchTasks();
                    router.push({name:'TaskList'})
                    messages.value = res.data.message;
                    console.log('Data Created');
                }else{
                    error.value = res.data.message;
                }
            }).catch(e=>{
                error.value = e.response.data.message
            })
        };
        const updateTasks = async (id) =>{
            const response = await axios.put(`/api/tasks/`+id,null, {
                headers: {
                    'Authorization': `Bearer ${store.getToken}`,
                },
            }).then(res=>{
                if(res.data.status == true){
                    fetchTasks();
                    router.push({name:'TaskList'})
                    messages.value = res.data.message;
                    console.log('Data Updated');
                }else{
                    error.value = res.data.message;
                }
            }).catch(e=>{
                error.value = e.response.data.message
            })
        };
        const deleteTasks = async (id) =>{
            axios.delete('/api/tasks/'+id,{
                headers: {
                    'Authorization': `Bearer ${store.getToken}`,
                },
            }).then(res=>{
                console.log(res)
                if(res.status == 204){
                    fetchTasks();
                    router.push({name:'TaskList'})
                    messages.value = res.message;
                    console.log('Sucessfully Deleted');
                }else{
                    error.value = res.data.message;
                }
            }).catch(e=>{
                error.value = e.response.data.message
            })
        }
        return{
            form,
            selectedStatus,
            fetchTasksByStatus,
            insertTasks,
            updateTasks,
            deleteTasks,
            error,
            messages,
            ...toRefs(state),
        }
    },
}
</script>