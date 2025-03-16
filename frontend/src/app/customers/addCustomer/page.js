// "use client";
// import { useState } from "react";
// import useCustomersApi from "@/api/CustomersApi";

// const addCustomerPage = () => {
//   const [salesmens_code, setSalesmenCode] = useState("");
//   const [name, setName] = useState("");
//   const [tel1, setTel1] = useState("");
//   const [tel2, setTel2] = useState("");
//   const [address, setAddress] = useState("");
//   const [gender, setGender] = useState("");
//   const [subscriptionDate, setSubscriptionDate] = useState("");
//   const [rate, setRate] = useState("");
//   const [photo, setPhoto] = useState(null);
//   const [tags, setTags] = useState([]);

//   const { addCustomer } = useCustomersApi();

//   const handleAddCustomer = async (e) => {
//     e.preventDefault();

//     const formData = new FormData();
//     formData.append("salesmen_code", salesmens_code);
//     formData.append("name", name);
//     formData.append("tel1", tel1);
//     formData.append("tel2", tel2);
//     formData.append("address", address);
//     formData.append("gender", gender);
//     formData.append("subscription_date", subscriptionDate);
//     formData.append("rate", rate);
    
//     if (photo) {
//       formData.append("photo", photo);
//     }

//     tags.forEach((tag) => {
//       formData.append("tags[]", tag);
//     });

//     try {
//       await addCustomer(formData);
//       alert("Customer added successfully");
//     } catch (error) {
//       alert("Failed to add customer");
//     }
//   };

//   return (
//     <div>
//       <h2>Add Customer</h2>

//       <form onSubmit={handleAddCustomer} encType="multipart/form-data">
//         <input
//           type="number"
//           placeholder="Salesman Code"
//           value={salesmens_code}
//           onChange={(e) => setSalesmenCode(e.target.value)}
//           required
//         />

//         <input
//           type="text"
//           placeholder="Name"
//           value={name}
//           onChange={(e) => setName(e.target.value)}
//           required
//         />

//         <input
//           type="text"
//           placeholder="Phone Number"
//           value={tel1}
//           onChange={(e) => setTel1(e.target.value)}
//         />

//         <input
//           type="text"
//           placeholder="Alternative Phone Number"
//           value={tel2}
//           onChange={(e) => setTel2(e.target.value)}
//         />

//         <input
//           type="text"
//           placeholder="Address"
//           value={address}
//           onChange={(e) => setAddress(e.target.value)}
//         />

//         <input
//           type="text"
//           placeholder="Gender"
//           value={gender}
//           onChange={(e) => setGender(e.target.value)}
//         />

//         <input
//           type="date"
//           placeholder="Subscription Date"
//           value={subscriptionDate}
//           onChange={(e) => setSubscriptionDate(e.target.value)}
//         />

//         <input
//           type="number"
//           placeholder="Rate"
//           value={rate}
//           onChange={(e) => setRate(e.target.value)}
//         />

//         <input
//           type="file"
//           accept="image/*"
//           onChange={(e) => setPhoto(e.target.files[0])}
//         />

//         <input
//           type="text"
//           placeholder="Enter tags (comma-separated)"
//           value={tags.join(", ")}
//           onChange={(e) =>
//             setTags(e.target.value.split(",").map((tag) => tag.trim()))
//           }
//         />

//         <button type="submit">Add Customer</button>
//       </form>
//     </div>
//   );
// };
// export default addCustomerPage;


"use client";
import { useState } from "react";
import useCustomersApi from "@/api/CustomersApi";

const AddCustomerPage = () => {
  const [formData, setFormData] = useState({
    salesmens_code: "",
    name: "",
    tel1: "",
    tel2: "",
    address: "",
    gender: "",
    subscriptionDate: "",
    rate: "",
    photo: null,
    tags: [],
  });

  const { addCustomer } = useCustomersApi();

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
  };

  const handleFileChange = (e) => {
    setFormData((prev) => ({ ...prev, photo: e.target.files[0] }));
  };

  const handleTagsChange = (e) => {
    setFormData((prev) => ({
      ...prev,
      tags: e.target.value.split(",").map((tag) => tag.trim()),
    }));
  };

  const handleAddCustomer = async (e) => {
    e.preventDefault();

    const submissionData = new FormData();
    submissionData.append("salesmens_code", formData.salesmens_code);
    submissionData.append("name", formData.name);
    submissionData.append("tel1", formData.tel1);
    submissionData.append("tel2", formData.tel2);
    submissionData.append("address", formData.address);
    submissionData.append("gender", formData.gender);
    submissionData.append("subscription_date", formData.subscriptionDate);
    submissionData.append("rate", formData.rate);

    if (formData.photo) {
      submissionData.append("photo", formData.photo);
    }

    formData.tags.forEach((tag) => {
      submissionData.append("tags[]", tag);
    });

    try {
      await addCustomer(submissionData);
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
          name="salesmens_code"
          placeholder="Salesman Code"
          value={formData.salesmens_code}
          onChange={handleChange}
          required
        />

        <input
          type="text"
          name="name"
          placeholder="Name"
          value={formData.name}
          onChange={handleChange}
          required
        />

        <input
          type="text"
          name="tel1"
          placeholder="Phone Number"
          value={formData.tel1}
          onChange={handleChange}
        />

        <input
          type="text"
          name="tel2"
          placeholder="Alternative Phone Number"
          value={formData.tel2}
          onChange={handleChange}
        />

        <input
          type="text"
          name="address"
          placeholder="Address"
          value={formData.address}
          onChange={handleChange}
        />

        <input
          type="text"
          name="gender"
          placeholder="Gender"
          value={formData.gender}
          onChange={handleChange}
        />

        <input
          type="date"
          name="subscriptionDate"
          placeholder="Subscription Date"
          value={formData.subscriptionDate}
          onChange={handleChange}
        />

        <input
          type="number"
          name="rate"
          placeholder="Rate"
          value={formData.rate}
          onChange={handleChange}
        />

        <input
          type="file"
          accept="image/*"
          onChange={handleFileChange}
        />

        <input
          type="text"
          placeholder="Enter tags (comma-separated)"
          value={formData.tags.join(", ")}
          onChange={handleTagsChange}
        />

        <button type="submit">Add Customer</button>
      </form>
    </div>
  );
};

export default AddCustomerPage;
