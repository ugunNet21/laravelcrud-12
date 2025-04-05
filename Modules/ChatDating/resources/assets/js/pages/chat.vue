<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Dating App</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue@3.2.31/dist/vue.global.prod.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100">
    <div id="app" class="container mx-auto px-4 py-8">
        <!-- Login/Register Form -->
        <div v-if="!isLoggedIn" class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden p-6">
            <h2 class="text-2xl font-bold mb-6 text-center text-indigo-600">{{ isRegistering ? 'Register' : 'Login' }}</h2>
            
            <form @submit.prevent="isRegistering ? register() : login()">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                    <input v-model="loginForm.email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" placeholder="Email" required>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                    <input v-model="loginForm.password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="Password" required>
                </div>
                
                <div v-if="isRegistering" class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
                    <input v-model="loginForm.name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="Name" required>
                </div>
                
                <div class="flex items-center justify-between">
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        {{ isRegistering ? 'Register' : 'Login' }}
                    </button>
                    <button @click.prevent="isRegistering = !isRegistering" class="inline-block align-baseline font-bold text-sm text-indigo-600 hover:text-indigo-800" type="button">
                        {{ isRegistering ? 'Already have an account? Login' : 'Need an account? Register' }}
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Main App -->
        <div v-else class="flex flex-col md:flex-row h-screen">
            <!-- Sidebar - User List -->
            <div class="w-full md:w-1/3 lg:w-1/4 bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-4 bg-indigo-600 text-white">
                    <h2 class="text-lg font-bold">{{ currentUser.name }}</h2>
                    <p class="text-sm opacity-80">{{ currentUser.email }}</p>
                    <button @click="logout" class="mt-2 px-3 py-1 bg-white text-indigo-600 text-sm rounded-md hover:bg-gray-100">Logout</button>
                </div>
                
                <div class="p-4 border-b">
                    <input v-model="search" class="w-full px-3 py-2 border rounded-md" placeholder="Search users...">
                </div>
                
                <div class="overflow-y-auto" style="max-height: calc(100vh - 200px);">
                    <div class="flex justify-between p-2 border-b bg-gray-100">
                        <button @click="activeTab = 'all'" :class="{'font-bold text-indigo-600': activeTab === 'all'}" class="px-2">All Users</button>
                        <button @click="activeTab = 'friends'" :class="{'font-bold text-indigo-600': activeTab === 'friends'}" class="px-2">Friends</button>
                        <button @click="activeTab = 'pending'" :class="{'font-bold text-indigo-600': activeTab === 'pending'}" class="px-2">Pending</button>
                    </div>
                    
                    <div v-if="activeTab === 'all'" class="user-list">
                        <div v-for="user in filteredUsers" :key="user.id" @click="selectUser(user)" class="p-3 border-b hover:bg-gray-100 cursor-pointer flex justify-between items-center" :class="{'bg-gray-200': selectedUser && selectedUser.id === user.id}">
                            <div>
                                <h3 class="font-medium">{{ user.name }}</h3>
                                <p class="text-xs text-gray-600">{{ calculateDistance(user) }} km away</p>
                            </div>
                            <button v-if="!isFriend(user)" @click.stop="addFriend(user)" class="px-2 py-1 bg-indigo-600 text-white text-xs rounded hover:bg-indigo-700">Add</button>
                            <span v-else-if="isFriendPending(user)" class="text-xs text-yellow-600">Pending</span>
                            <span v-else class="text-xs text-green-600">Friend</span>
                        </div>
                    </div>
                    
                    <div v-if="activeTab === 'friends'" class="user-list">
                        <div v-for="friendship in acceptedFriendships" :key="friendship.id" @click="selectUserById(getFriendId(friendship))" class="p-3 border-b hover:bg-gray-100 cursor-pointer" :class="{'bg-gray-200': selectedUser && selectedUser.id === getFriendId(friendship)}">
                            <h3 class="font-medium">{{ getFriendName(friendship) }}</h3>
                            <p class="text-xs text-gray-600">{{ getLastMessage(getFriendId(friendship)) }}</p>
                        </div>
                    </div>
                    
                    <div v-if="activeTab === 'pending'" class="user-list">
                        <div v-for="friendship in pendingFriendships" :key="friendship.id" class="p-3 border-b hover:bg-gray-100">
                            <h3 class="font-medium">{{ getFriendName(friendship) }}</h3>
                            <div class="flex mt-1">
                                <button @click="acceptFriendship(friendship)" class="px-2 py-1 bg-green-600 text-white text-xs rounded mr-2">Accept</button>
                                <button @click="rejectFriendship(friendship)" class="px-2 py-1 bg-red-600 text-white text-xs rounded">Reject</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Chat Area -->
            <div class="w-full md:w-2/3 lg:w-3/4 bg-gray-50 flex flex-col">
                <div v-if="selectedUser" class="bg-white shadow-sm p-4 border-b flex justify-between items-center">
                    <div>
                        <h2 class="font-bold">{{ selectedUser.name }}</h2>
                        <p class="text-xs text-gray-600">{{ selectedUser.email }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span v-if="isFriend(selectedUser)" class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Friend</span>
                        <button v-if="isFriend(selectedUser)" @click="blockUser(selectedUser)" class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded">Block</button>
                    </div>
                </div>
                
                <div v-if="selectedUser" class="flex-grow p-4 overflow-y-auto" style="max-height: calc(100vh - 200px);">
                    <div v-for="message in selectedUserMessages" :key="message.id" class="mb-4">
                        <div :class="message.sender_id === currentUser.id ? 'ml-auto bg-indigo-600 text-white' : 'mr-auto bg-gray-300 text-gray-800'" class="max-w-xs md:max-w-md rounded-lg p-3">
                            {{ message.message }}
                        </div>
                        <div :class="message.sender_id === currentUser.id ? 'text-right' : 'text-left'" class="text-xs text-gray-500 mt-1">
                            {{ formatDate(message.created_at) }}
                        </div>
                    </div>
                </div>
                
                <div v-if="selectedUser" class="p-4 bg-white border-t">
                    <form @submit.prevent="sendMessage" class="flex">
                        <input v-model="newMessage" class="flex-grow px-4 py-2 border rounded-l-md focus:outline-none" placeholder="Type a message...">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-r-md hover:bg-indigo-700">Send</button>
                    </form>
                </div>
                
                <div v-else class="flex-grow flex items-center justify-center text-gray-500">
                    <p>Select a user to start chatting</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const { createApp, ref, computed, onMounted, watch } = Vue;
        
        createApp({
            setup() {
                // Authentication
                const isLoggedIn = ref(false);
                const isRegistering = ref(false);
                const loginForm = ref({ email: '', password: '', name: '' });
                const currentUser = ref(null);
                
                // UI State
                const activeTab = ref('all');
                const search = ref('');
                const users = ref([]);
                const friendships = ref([]);
                const messages = ref([]);
                const selectedUser = ref(null);
                const newMessage = ref('');
                
                // Computed properties
                const filteredUsers = computed(() => {
                    return users.value.filter(user => 
                        user.id !== currentUser.value?.id && 
                        user.name.toLowerCase().includes(search.value.toLowerCase())
                    );
                });
                
                const acceptedFriendships = computed(() => {
                    return friendships.value.filter(f => 
                        f.status === 'accepted' && 
                        (f.user_id === currentUser.value?.id || f.friend_id === currentUser.value?.id)
                    );
                });
                
                const pendingFriendships = computed(() => {
                    return friendships.value.filter(f => 
                        f.status === 'pending' && f.friend_id === currentUser.value?.id
                    );
                });
                
                const selectedUserMessages = computed(() => {
                    if (!selectedUser.value) return [];
                    return messages.value.filter(m => 
                        (m.sender_id === currentUser.value?.id && m.receiver_id === selectedUser.value?.id) ||
                        (m.sender_id === selectedUser.value?.id && m.receiver_id === currentUser.value?.id)
                    ).sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                });
                
                // Methods
                const login = async () => {
                    // Simulate login for demo purposes
                    // In a real app, you would call your API endpoint
                    try {
                        const response = await axios.get('/api/user-chat');
                        users.value = response.data;
                        // For demo: just select the first user as current user
                        currentUser.value = users.value.find(u => u.email === loginForm.value.email) || users.value[0];
                        isLoggedIn.value = true;
                        fetchFriendships();
                        fetchMessages();
                    } catch (error) {
                        console.error('Login failed', error);
                        alert('Login failed');
                    }
                };
                
                const register = async () => {
                    // Simulate registration for demo purposes
                    alert('Registration would be implemented in a real app');
                    // Switch to login view
                    isRegistering.value = false;
                };
                
                const logout = () => {
                    isLoggedIn.value = false;
                    currentUser.value = null;
                    loginForm.value = { email: '', password: '', name: '' };
                };
                
                const fetchUsers = async () => {
                    try {
                        const response = await axios.get('/api/user-chat');
                        users.value = response.data;
                    } catch (error) {
                        console.error('Failed to fetch users', error);
                    }
                };
                
                const fetchFriendships = async () => {
                    try {
                        const response = await axios.get('/api/friendships');
                        friendships.value = response.data;
                    } catch (error) {
                        console.error('Failed to fetch friendships', error);
                    }
                };
                
                const fetchMessages = async () => {
                    try {
                        const response = await axios.get('/api/messages');
                        messages.value = response.data;
                    } catch (error) {
                        console.error('Failed to fetch messages', error);
                    }
                };
                
                const selectUser = (user) => {
                    selectedUser.value = user;
                    markMessagesAsRead();
                };
                
                const selectUserById = (userId) => {
                    const user = users.value.find(u => u.id === userId);
                    if (user) {
                        selectedUser.value = user;
                        markMessagesAsRead();
                    }
                };
                
                const markMessagesAsRead = async () => {
                    // In a real app, you would call your API to mark messages as read
                    console.log('Marking messages as read');
                };
                
                const sendMessage = async () => {
                    if (!newMessage.value.trim() || !selectedUser.value) return;
                    
                    const message = {
                        id: messages.value.length + 1,
                        sender_id: currentUser.value.id,
                        receiver_id: selectedUser.value.id,
                        message: newMessage.value,
                        read_at: null,
                        created_at: new Date().toISOString(),
                        updated_at: new Date().toISOString()
                    };
                    
                    try {
                        // In a real app, you would call your API to send the message
                        // const response = await axios.post('/api/messages', message);
                        // message.id = response.data.id;
                        messages.value.push(message);
                        newMessage.value = '';
                    } catch (error) {
                        console.error('Failed to send message', error);
                    }
                };
                
                const addFriend = async (user) => {
                    const friendship = {
                        user_id: currentUser.value.id,
                        friend_id: user.id,
                        status: 'pending'
                    };
                    
                    try {
                        // In a real app, you would call your API to create the friendship
                        // const response = await axios.post('/api/friendships', friendship);
                        // friendship.id = response.data.id;
                        friendship.id = friendships.value.length + 1;
                        friendship.created_at = new Date().toISOString();
                        friendship.updated_at = new Date().toISOString();
                        friendships.value.push(friendship);
                    } catch (error) {
                        console.error('Failed to add friend', error);
                    }
                };
                
                const acceptFriendship = async (friendship) => {
                    try {
                        // In a real app, you would call your API to update the friendship
                        // await axios.put(`/api/friendships/${friendship.id}`, { status: 'accepted' });
                        const index = friendships.value.findIndex(f => f.id === friendship.id);
                        if (index !== -1) {
                            friendships.value[index].status = 'accepted';
                        }
                    } catch (error) {
                        console.error('Failed to accept friendship', error);
                    }
                };
                
                const rejectFriendship = async (friendship) => {
                    try {
                        // In a real app, you would call your API to delete or update the friendship
                        // await axios.delete(`/api/friendships/${friendship.id}`);
                        friendships.value = friendships.value.filter(f => f.id !== friendship.id);
                    } catch (error) {
                        console.error('Failed to reject friendship', error);
                    }
                };
                
                const blockUser = async (user) => {
                    // Find the friendship
                    const friendship = friendships.value.find(f => 
                        (f.user_id === currentUser.value.id && f.friend_id === user.id) ||
                        (f.user_id === user.id && f.friend_id === currentUser.value.id)
                    );
                    
                    if (friendship) {
                        try {
                            // In a real app, you would call your API to update the friendship
                            // await axios.put(`/api/friendships/${friendship.id}`, { status: 'blocked' });
                            friendship.status = 'blocked';
                        } catch (error) {
                            console.error('Failed to block user', error);
                        }
                    }
                };
                
                const isFriend = (user) => {
                    return friendships.value.some(f => 
                        f.status === 'accepted' && 
                        ((f.user_id === currentUser.value?.id && f.friend_id === user.id) ||
                        (f.user_id === user.id && f.friend_id === currentUser.value?.id))
                    );
                };
                
                const isFriendPending = (user) => {
                    return friendships.value.some(f => 
                        f.status === 'pending' && 
                        ((f.user_id === currentUser.value?.id && f.friend_id === user.id) ||
                        (f.user_id === user.id && f.friend_id === currentUser.value?.id))
                    );
                };
                
                const getFriendId = (friendship) => {
                    return friendship.user_id === currentUser.value?.id ? friendship.friend_id : friendship.user_id;
                };
                
                const getFriendName = (friendship) => {
                    const friendId = getFriendId(friendship);
                    const friend = users.value.find(u => u.id === friendId);
                    return friend ? friend.name : 'Unknown User';
                };
                
                const getLastMessage = (userId) => {
                    const relevantMessages = messages.value.filter(m => 
                        (m.sender_id === currentUser.value?.id && m.receiver_id === userId) ||
                        (m.sender_id === userId && m.receiver_id === currentUser.value?.id)
                    ).sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                    
                    if (relevantMessages.length === 0) return 'No messages yet';
                    
                    const lastMessage = relevantMessages[0];
                    const preview = lastMessage.message.length > 20 
                        ? lastMessage.message.substring(0, 20) + '...' 
                        : lastMessage.message;
                        
                    return preview;
                };
                
                const formatDate = (dateString) => {
                    const date = new Date(dateString);
                    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                };
                
                const calculateDistance = (user) => {
                    if (!currentUser.value || !user.latitude || !user.longitude) return 'Unknown';
                    
                    // Simple distance calculation (not accurate for real-world use)
                    const lat1 = currentUser.value.latitude;
                    const lon1 = currentUser.value.longitude;
                    const lat2 = user.latitude;
                    const lon2 = user.longitude;
                    
                    const R = 6371; // Radius of the earth in km
                    const dLat = deg2rad(lat2 - lat1);
                    const dLon = deg2rad(lon2 - lon1);
                    const a = 
                        Math.sin(dLat/2) * Math.sin(dLat/2) +
                        Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
                        Math.sin(dLon/2) * Math.sin(dLon/2); 
                    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
                    const d = R * c; // Distance in km
                    
                    return d.toFixed(1);
                };
                
                const deg2rad = (deg) => {
                    return deg * (Math.PI/180);
                };
                
                // Initialize app
                onMounted(() => {
                    fetchUsers();
                });
                
                return {
                    // Authentication
                    isLoggedIn,
                    isRegistering,
                    loginForm,
                    currentUser,
                    login,
                    register,
                    logout,
                    
                    // Data
                    users,
                    friendships,
                    messages,
                    
                    // UI State
                    activeTab,
                    search,
                    selectedUser,
                    newMessage,
                    
                    // Computed
                    filteredUsers,
                    acceptedFriendships,
                    pendingFriendships,
                    selectedUserMessages,
                    
                    // Methods
                    selectUser,
                    selectUserById,
                    sendMessage,
                    addFriend,
                    acceptFriendship,
                    rejectFriendship,
                    blockUser,
                    isFriend,
                    isFriendPending,
                    getFriendId,
                    getFriendName,
                    getLastMessage,
                    formatDate,
                    calculateDistance
                };
            }
        }).mount('#app');
    </script>
</body>
</html>