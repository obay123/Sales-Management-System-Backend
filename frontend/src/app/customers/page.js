'use client'

import { useEffect, useState } from "react";
import useCustomersApi from "@/api/customersApi";

export default function Customers() {
  const [customers, setCustomers] = useState([]);

  useEffect(() => {
    const fetchCustomers = async () => {
      try {
        const { getCustomers } = useCustomersApi();
        const data = await getCustomers();
        setCustomers(data);
      } catch (error) {
        console.error("Error fetching customers:", error);
      }
    };
    fetchCustomers();
  }, []);

  console.log(customers);

  return (
    <div className="main-div">
      <h1>Main Page</h1>
    </div>
  );
}
