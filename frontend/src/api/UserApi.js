


const userApi  = ()=>{

 const  register = async (name, email, password) => {
    try {
        const response = await fetch('/api/register', {
            method: 'POST',
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ name, email, password })
        });
        const data = await response.json(); 
        if (!response.ok) throw new Error(data.message || 'Registration failed');
        return data;
    } catch (error) {
        console.error("Register Error:", error.message);
        throw error;
    }
};

 const login = async (email, password) => {
    try {
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ email, password })
        });
        const data = await response.json();
        if (!response.ok) throw new Error(data.message);
        localStorage.setItem('Token', data.token);
        return data;
    } catch (error) {
        throw error.message;
    }
};

 const logout = async () => {
    try {
        const response = await fetch('/api/logout', {
            method: 'POST',
            headers: { "Content-Type": "application/json" }
        });
        const data = await response.json();
        if (!response.ok) throw new Error(data.message || "Logout failed");
        localStorage.clear();
        return data ;
    } catch (error) {
        console.error("Logout Error:", error.message);
        throw error;
    }
};
return {logout,login,register}
}

export default userApi ;