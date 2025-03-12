'use client'

import { useEffect, useState } from "react";
import useSalesmensApi from "@/api/salesmenApi";

export default function Salesmen() {
  const [Salesmen, setSalesmen] = useState([]);

  useEffect(() => {
    const fetchSalesmen = async () => {
      try {
        const { getSalesmen } = useSalesmensApi();
        const data = await getSalesmen();
        setSalesmen(data);
      } catch (error) {
        console.error("Error fetching items:", error);
      }
    };
    fetchSalesmen();
  }, []);

  console.log(Salesmen);

  return (
    <div className="main-div">
      <h1>Salesmen Page</h1>
    </div>
  );
}
