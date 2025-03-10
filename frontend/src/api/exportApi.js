
const exportToExcell = async (url) => {

    const token = localStorage.getItem('token')
    if (!token) {
        throw new Error("No auth token found");
    }
    try {
        const exportToExcell = async (url) => {
            const response = await fetch(`${url}/export`, {
                method: 'GET',
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${token}`
                },
            })
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(`failed to export ${url}`);
            }
            return 'Export successful ! '
        }
    } catch (error) {
        throw error
    }
}

export default exportToExcell ; 