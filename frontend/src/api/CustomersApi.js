const API_URL = "/api/customers";

const useCustomersApi = () => {
  const getToken = () =>
    typeof window !== "undefined" ? localStorage.getItem("Token") : null;
  const Token = getToken();

  // const addCustomer = async (
  //   salesmen_code,
  //   name,
  //   tel1,
  //   tel2,
  //   address,
  //   gender,
  //   subscription_date,
  //   rate,
  //   photo,
  //   tags
  // ) => {
  //   if (!Token) {
  //     throw new Error("No auth token found");
  //   }
  //   try {
  //     const formData = new FormData();
  //     formData.append("salesmen_code", salesmen_code);
  //     formData.append("name", name);
  //     formData.append("tel1", tel1);
  //     formData.append("tel2", tel2);
  //     formData.append("address", address);
  //     formData.append("gender", gender);
  //     formData.append("subscription_date", subscription_date);
  //     formData.append("rate", rate);

  //     if (photo) {
  //       formData.append("photo", photo); // ✅ Correct way to send files
  //     }

  //     if (Array.isArray(tags)) {
  //       tags.forEach((tag) => {
  //         formData.append("tags[]", tag); // ✅ Correct way to send array
  //       });
  //     }

  //     const response = await fetch(API_URL, {
  //       method: "POST",
  //       headers: {
  //         Authorization: `Bearer ${Token}`, // ✅ No need for Content-Type
  //       },
  //       body: formData,
  //     });

  //     const textResponse = await response.text();
  //     console.log("Raw API Response:", textResponse);

  //     try {
  //       const jsonResponse = JSON.parse(textResponse);
  //       if (!response.ok)
  //         throw new Error(jsonResponse.message || "Failed to add customer");
  //       return jsonResponse;
  //     } catch (error) {
  //       throw new Error("Invalid JSON response from server");
  //     }
  //   } catch (error) {
  //     console.error("Error adding customer:", error.message);
  //     throw error;
  //   }
  // };

  const addCustomer = async (customerData) => {
    if (!Token) {
      throw new Error("No auth token found");
    }
    try {
      const response = await fetch(`${API_URL}`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${Token}`,
          Accept: "application/json",
        },
        body: JSON.stringify(customerData),
      });
      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || "Failed to add customer");
      }
      return await response.json();
    } catch (error) {
      console.error("Error adding customer:", error.message);
      throw error;
    }
  };

  const getCustomers = async () => {
    if (!Token) {
      throw new Error("No auth token found");
    }
    try {
      const response = await fetch(`${API_URL}`, {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${Token}`,
        },
      });
      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || "Failed to fetch customers");
      }
      return await response.json();
    } catch (error) {
      console.error("Error fetching customers:", error.message);
      throw error;
    }
  };

  const deleteCustomer = async (id) => {
    if (!Token) {
      throw new Error("No auth token found");
    }
    try {
      const response = await fetch(`${API_URL}/${id}`, {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${Token}`,
        },
      });
      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || "Failed to delete customer");
      }
      return await response.json();
    } catch (error) {
      throw error;
    }
  };

  const updateCustomer = async (id, updatedData) => {
    if (!Token) {
      throw new Error("No auth token found");
    }
    try {
      const response = await fetch(`${API_URL}/${id}`, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${Token}`,
        },
        body: JSON.stringify(updatedData),
      });
      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || "Failed to update customer");
      }
      return await response.json();
    } catch (error) {
      console.error("Error updating customer:", error.message);
      throw error;
    }
  };

  const showCustomer = async (id) => {
    if (!Token) {
      throw new Error("No auth token found");
    }
    try {
      const response = await fetch(`${API_URL}/${id}`, {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${Token}`,
        },
      });
      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(
          errorData.message || "Failed to fetch customer details"
        );
      }
      return await response.json();
    } catch (error) {
      console.error("Error fetching customer details:", error.message);
      throw error;
    }
  };

  const bulkDeleteCustomers = async (ids) => {
    if (!Token) {
      throw new Error("No auth token found");
    }
    try {
      const response = await fetch(`${API_URL}/bulk-delete`, {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${Token}`,
        },
        body: JSON.stringify({ ids }),
      });
      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || "Failed to delete customers");
      }
      return await response.json();
    } catch (error) {
      console.error("Error deleting customers:", error.message);
      throw error;
    }
  };

  return {
    addCustomer,
    getCustomers,
    deleteCustomer,
    updateCustomer,
    showCustomer,
    bulkDeleteCustomers,
  };
};

export default useCustomersApi;
