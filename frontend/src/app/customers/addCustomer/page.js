"use client";
import { useState } from "react";
import useCustomersApi from "@/api/CustomersApi";

const addCustomerPage = () => {
  const [salesmenCode, setSalesmenCode] = useState("");
  const [name, setName] = useState("");
  const [tel1, setTel1] = useState("");
  const [tel2, setTel2] = useState("");
  const [address, setAddress] = useState("");
  const [gender, setGender] = useState("");
  const [subscriptionDate, setSubscriptionDate] = useState("");
  const [rate, setRate] = useState("");
  const [photo, setPhoto] = useState(null);
  const [tags, setTags] = useState([]);

  const { addCustomer } = useCustomersApi();

  const handleAddCustomer = async (e) => {
    e.preventDefault();

    const formData = new FormData();
    formData.append("salesmen_code", salesmenCode);
    formData.append("name", name);
    formData.append("tel1", tel1);
    formData.append("tel2", tel2);
    formData.append("address", address);
    formData.append("gender", gender);
    formData.append("subscription_date", subscriptionDate);
    formData.append("rate", rate);
    
    if (photo) {
      formData.append("photo", photo);
    }

    tags.forEach((tag) => {
      formData.append("tags[]", tag);
    });

    try {
      await addCustomer(formData);
      alert("Customer added successfully");
    } catch (error) {
      alert("Failed to add customer");
    }
  };

  return (
    <div>
      <h2>Add Customer</h2>

      <form onSubmit={handleAddCustomer} encType="multipart/form-data">
        <input
          type="number"
          placeholder="Salesman Code"
          value={salesmenCode}
          onChange={(e) => setSalesmenCode(e.target.value)}
          required
        />

        <input
          type="text"
          placeholder="Name"
          value={name}
          onChange={(e) => setName(e.target.value)}
          required
        />

        <input
          type="text"
          placeholder="Phone Number"
          value={tel1}
          onChange={(e) => setTel1(e.target.value)}
        />

        <input
          type="text"
          placeholder="Alternative Phone Number"
          value={tel2}
          onChange={(e) => setTel2(e.target.value)}
        />

        <input
          type="text"
          placeholder="Address"
          value={address}
          onChange={(e) => setAddress(e.target.value)}
        />

        <input
          type="text"
          placeholder="Gender"
          value={gender}
          onChange={(e) => setGender(e.target.value)}
        />

        <input
          type="date"
          placeholder="Subscription Date"
          value={subscriptionDate}
          onChange={(e) => setSubscriptionDate(e.target.value)}
        />

        <input
          type="number"
          placeholder="Rate"
          value={rate}
          onChange={(e) => setRate(e.target.value)}
        />

        <input
          type="file"
          accept="image/*"
          onChange={(e) => setPhoto(e.target.files[0])}
        />

        <input
          type="text"
          placeholder="Enter tags (comma-separated)"
          value={tags.join(", ")}
          onChange={(e) =>
            setTags(e.target.value.split(",").map((tag) => tag.trim()))
          }
        />

        <button type="submit">Add Customer</button>
      </form>
    </div>
  );
};
export default addCustomerPage;
