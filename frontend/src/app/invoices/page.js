'use client'
import { useEffect, useState } from "react";
import useInvoicesApi from "@/api/InvoicesApi";

export default function Invoices() {
  const [invoices, setInvioces] = useState([]);

  useEffect(() => {
    const fetchInvoices = async () => {
      try {
        const { getInvoices } = useInvoicesApi();
        const data = await getInvoices();
        setInvioces(data.invoices.data);
        
      } catch (error) {
        console.error("Error fetching invoices:", error);
      }
    };
    fetchInvoices();
  }, []);
  console.log(invoices)
  return (
    <div className="main-div">
      <h1>invoices page</h1>
    </div>
  );
}
