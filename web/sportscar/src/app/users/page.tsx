"use client";
import React, { useState, useEffect } from "react";
import { motion } from "framer-motion";
import Image from "next/image";
import Header from "@/components/Header";

interface UserProfile {
  userId: string;
  firstName: string;
  lastName: string;
  username: string;
  image: string;
  phone: string;
  address: string;
}

interface UpdateMessage {
  type: 'success' | 'error';
  text: string;
}

interface Transaction {
  id: number;
  type: 'purchase' | 'rental';
  carName: string;
  date: string;
  amount: number;
  status: string;
  startDate?: string;
  endDate?: string;
  duration?: string;
}

const UserProfiles = () => {
  const [user, setUser] = useState<UserProfile | null>(null);
  const [isEditing, setIsEditing] = useState(false);
  const [formData, setFormData] = useState({
    firstName: '',
    lastName: '',
    phone: '',
    address: '',
    image: null as File | null
  });
  const [updateMessage, setUpdateMessage] = useState<UpdateMessage | null>(null);
  const [transactions, setTransactions] = useState<Transaction[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchUser = async () => {
      try {
        const storedUser = localStorage.getItem("user");
        if (storedUser) {
          const userData = JSON.parse(storedUser);
          setUser(userData);
        } else {
          console.error('No user data found in local storage');
        }
      } catch (error) {
        console.error('Error fetching user:', error);
      }
    };

    fetchUser();
  }, []);

  useEffect(() => {
    if (user) {
      setFormData({
        firstName: user.firstName || '',
        lastName: user.lastName || '',
        phone: user.phone || '',
        address: user.address || '',
        image: null
      });
    }
  }, [user]);

  useEffect(() => {
    const fetchTransactions = async () => {
      try {
        const userId = JSON.parse(localStorage.getItem("user") || "{}").userId;
        
        if (!userId) {
          console.error('No user ID found');
          setLoading(false);
          return;
        }

        // Fetch rentals only since orders endpoint is not available
        const rentalsResponse = await fetch(`http://localhost:8000/api/rent/user/${userId}`);
        if (!rentalsResponse.ok) {
          throw new Error(`Rentals fetch failed: ${rentalsResponse.statusText}`);
        }
        const rentalsData = await rentalsResponse.json();

        console.log('Rentals response:', rentalsData);

        // Format transactions with only rental data
        const allTransactions = [
          ...(rentalsData.rentals || []).map((r: any) => ({
            id: r.rentId,
            type: 'rental',
            carName: r.brandModel,
            date: new Date(r.created_at).toLocaleDateString(),
            amount: r.rentPrice,
            status: r.status,
            startDate: new Date(r.startDate).toLocaleDateString(),
            endDate: new Date(r.endDate).toLocaleDateString(),
            duration: r.rentDuration
          }))
        ].sort((a, b) => new Date(b.date).getTime() - new Date(a.date).getTime());

        setTransactions(allTransactions);
        setLoading(false);
      } catch (error) {
        console.error('Error details:', error);
        // Set empty transactions array instead of leaving previous state
        setTransactions([]);
        setLoading(false);
      }
    };

    fetchTransactions();
  }, []);

  const handleUpdate = async () => {
    try {
        if (!user?.userId) {
            throw new Error("User ID is missing");
        }

        const formDataToSend = new FormData();
        formDataToSend.append("firstName", formData.firstName || user.firstName);
        formDataToSend.append("lastName", formData.lastName || user.lastName);
        formDataToSend.append("phone", formData.phone || user.phone || "");
        formDataToSend.append("address", formData.address || user.address || "");
        formDataToSend.append("password", "password12345678");
        formDataToSend.append("confirmPassword", "password12345678");

        if (formData.image) {
            formDataToSend.append("image", formData.image);
        }

        formDataToSend.append('_method', 'PUT');

        const response = await fetch(
            `http://localhost:8000/api/user/update/${user.userId}`,
            {
                method: "POST",
                headers: {
                    "Accept": "application/json",
                },
                body: formDataToSend,
            }
        );

        const responseData = await response.json();

        if (!response.ok) {
            throw new Error(responseData.error || responseData.message || "Failed to update user");
        }

        const updatedUser = {
            ...user,
            firstName: formData.firstName || user.firstName,
            lastName: formData.lastName || user.lastName,
            phone: formData.phone || user.phone,
            address: formData.address || user.address,
            image: responseData.image
        };

        localStorage.setItem("user", JSON.stringify(updatedUser));
        setUser(updatedUser);
        setUpdateMessage({
            type: "success",
            text: "Profile updated successfully",
        });
        setIsEditing(false);
        
        const imageElement = document.querySelector('img') as HTMLImageElement;
        if (imageElement) {
            imageElement.src = `http://localhost:8000/images/users/${responseData.image}?t=${new Date().getTime()}`;
        }
    } catch (error: any) {
        console.error("Error updating user:", error);
        setUpdateMessage({
            type: "error",
            text: error.message || "Failed to update user information",
        });
    }
};

  return (
    <>
      <Header />
      <motion.section
        initial={{ opacity: 0 }}
        animate={{
          opacity: 1,
          transition: { delay: 0.4, duration: 0.4, ease: "easeIn" },
        }}
        className="min-h-[80vh] flex flex-col mt-4 bg-primary mb-12"
      >
        <div className="container mx-auto">
          <h1 className="text-3xl font-bold text-center mb-8 text-white">User Profile</h1>
          {user ? (
            <>
              <div className="flex items-center justify-center bg-secondary p-8 rounded-lg shadow-lg border-2 w-1/2 mx-auto border-accent">
                <div className="flex-shrink-0">
                  <Image
                    src={`http://localhost:8000/images/users/${user.image}`}
                    width={200}
                    height={200}
                    alt={`${user.firstName} ${user.lastName}`}
                    className="object-cover rounded-full"
                    unoptimized
                  />
                </div>
                <div className="ml-8 text-left">
                  <p className="text-2xl font-semibold text-white capitalize">
                    {user.firstName} {user.lastName}
                  </p>
                  <p className="text-lg text-gray-300">{user.username}</p>
                  
                  {isEditing ? (
                    <div className="mt-4 space-y-4">
                      <div>
                        <label className="block text-sm text-gray-400">First Name</label>
                        <input
                          type="text"
                          value={formData.firstName}
                          onChange={(e) => setFormData({ ...formData, firstName: e.target.value })}
                          className="mt-1 w-full px-3 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:border-accent focus:outline-none capitalize"
                        />
                      </div>
                      <div>
                        <label className="block text-sm text-gray-400">Last Name</label>
                        <input
                          type="text"
                          value={formData.lastName}
                          onChange={(e) => setFormData({ ...formData, lastName: e.target.value })}
                          className="mt-1 w-full px-3 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:border-accent focus:outline-none capitalize"
                        />
                      </div>
                      <div>
                        <label className="block text-sm text-gray-400">Phone</label>
                        <input
                          type="text"
                          value={formData.phone}
                          onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                          className="mt-1 w-full px-3 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:border-accent focus:outline-none"
                        />
                      </div>
                      <div>
                        <label className="block text-sm text-gray-400">Address</label>
                        <input
                          type="text"
                          value={formData.address}
                          onChange={(e) => setFormData({ ...formData, address: e.target.value })}
                          className="mt-1 w-full px-3 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:border-accent focus:outline-none capitalize"
                        />
                      </div>
                      <div>
                        <label className="block text-sm text-gray-400">Profile Image</label>
                        <input
                          type="file"
                          accept="image/*"
                          onChange={(e) => {
                            const file = e.target.files?.[0];
                            if (file) {
                              setFormData({ ...formData, image: file });
                            }
                          }}
                          className="mt-1 w-full px-3 py-2 bg-gray-700 text-white rounded border border-gray-600 focus:border-accent focus:outline-none"
                        />
                      </div>
                      <div className="flex space-x-4">
                        <button
                          onClick={handleUpdate}
                          className="px-4 py-2 bg-accent text-white rounded hover:bg-accent/80 transition"
                        >
                          Save
                        </button>
                        <button
                          onClick={() => setIsEditing(false)}
                          className="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition"
                        >
                          Cancel
                        </button>
                      </div>
                    </div>
                  ) : (
                    <div className="mt-4">
                      <p className="text-gray-300">Phone: {user.phone || 'Not set'}</p>
                      <p className="text-gray-300 capitalize">Address: {user.address || 'Not set'}</p>
                      <button
                        onClick={() => setIsEditing(true)}
                        className="mt-4 px-4 py-2 bg-accent text-white rounded hover:bg-accent/80 transition"
                      >
                        Update Info
                      </button>
                    </div>
                  )}
                </div>
              </div>
              {updateMessage && (
                <div className={`mt-4 text-center p-3 rounded ${
                  updateMessage.type === 'success' ? 'bg-green-600' : 'bg-red-600'
                } text-white w-1/2 mx-auto`}>
                  {updateMessage.text}
                </div>
              )}
            </>
          ) : (
            <p className="text-center text-white">Loading user profile...</p>
          )}
        </div>
      </motion.section>
      {user && (
        <div className="container mx-auto">
          <div className="bg-secondary p-8 rounded-lg shadow-lg border-2 w-1/2 mx-auto border-accent mb-12">
            <h2 className="text-2xl font-bold text-white mb-6">Transaction History</h2>
            
            {loading ? (
              <p className="text-gray-400 text-center">Loading transactions...</p>
            ) : transactions.length > 0 ? (
              <div className="space-y-4">
                {transactions.map((transaction) => (
                  <div key={transaction.id} className="bg-gray-800 p-4 rounded-lg hover:bg-gray-700 transition-colors">
                    <div className="flex justify-between items-center">
                      <div>
                        <h3 className="text-white font-semibold">
                          {transaction.type === 'purchase' ? 'Car Purchase' : 'Car Rental'} - {transaction.carName}
                        </h3>
                        <p className="text-gray-400">Date: {transaction.date}</p>
                        <span className={`text-sm ${
                          transaction.status === 'completed' ? 'text-green-400' : 
                          transaction.status === 'pending' ? 'text-yellow-400' : 'text-red-400'
                        }`}>
                          Status: {transaction.status}
                        </span>
                      </div>
                      <span className="text-accent font-bold">₱{transaction.amount.toLocaleString()}</span>
                    </div>
                  </div>
                ))}
              </div>
            ) : (
              <p className="text-gray-400 text-center">No transactions found</p>
            )}
          </div>
        </div>
      )}
      {user && (
        <div className="container mx-auto">
          <div className="bg-secondary p-8 rounded-lg shadow-lg border-2 w-1/2 mx-auto border-accent mb-12">
            <h2 className="text-2xl font-bold text-white mb-6">Active Rentals</h2>
            
            {loading ? (
              <p className="text-gray-400 text-center">Loading active rentals...</p>
            ) : transactions.filter(t => t.type === 'rental' && t.status.toLowerCase() === 'approved').length > 0 ? (
              <div className="space-y-4">
                {transactions
                  .filter(t => 
                    t.type === 'rental' && 
                    t.status.toLowerCase() === 'approved' &&
                    new Date(t.endDate) >= new Date()
                  )
                  .map((rental) => (
                    <div key={rental.id} 
                      className="bg-gray-800 p-6 rounded-lg hover:bg-gray-700 transition-colors border-l-4 border-green-500">
                      <div className="flex flex-col space-y-4">
                        <div className="flex justify-between items-start">
                          <div>
                            <h3 className="text-xl font-bold text-white mb-2">
                              {rental.carName}
                            </h3>
                            <div className="grid grid-cols-2 gap-4 text-sm">
                              <div>
                                <p className="text-gray-400">Start Date:</p>
                                <p className="text-white">{rental.startDate}</p>
                              </div>
                              <div>
                                <p className="text-gray-400">End Date:</p>
                                <p className="text-white">{rental.endDate}</p>
                              </div>
                              <div>
                                <p className="text-gray-400">Duration:</p>
                                <p className="text-white capitalize">{rental.duration}</p>
                              </div>
                              <div>
                                <p className="text-gray-400">Daily Rate:</p>
                                <p className="text-white">₱{(rental.amount / 
                                  (rental.duration === 'day' ? 1 : 
                                   rental.duration === 'week' ? 7 : 30)
                                ).toLocaleString()}</p>
                              </div>
                            </div>
                          </div>
                          <div className="text-right">
                            <div className="bg-accent/10 p-3 rounded-lg">
                              <p className="text-sm text-gray-400">Total Rental Fee</p>
                              <p className="text-2xl font-bold text-accent">
                                ₱{rental.amount.toLocaleString()}
                              </p>
                            </div>
                          </div>
                        </div>
                        <div className="flex items-center justify-between pt-4 border-t border-gray-700">
                          <span className="inline-flex items-center px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm">
                            <div className="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                            Active Rental
                          </span>
                          <p className="text-sm text-gray-400">
                            Rental ID: #{rental.id}
                          </p>
                        </div>
                      </div>
                    </div>
                  ))}
              </div>
            ) : (
              <p className="text-gray-400 text-center">No active rentals found</p>
            )}
          </div>
        </div>
      )}
    </>
  );
};

export default UserProfiles; 