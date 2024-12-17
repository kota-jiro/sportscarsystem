import { useState } from "react";

interface UpdateUserResponse {
  message?: string;
  error?: string;
}

interface UserUpdateData {
  firstName: string;
  lastName: string;
  address: string;
  password: string;
  confirmPassword: string;
  image?: File;
}

export const useUpdateUser = (userId: string) => {
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const updateUser = async (userData: UserUpdateData) => {
    setLoading(true);
    setError(null);

    try {
      const formData = new FormData();
      formData.append('firstName', userData.firstName);
      formData.append('lastName', userData.lastName);
      formData.append('address', userData.address);
      formData.append('password', userData.password);
      formData.append('confirmPassword', userData.confirmPassword);
      
      if (userData.image) {
        formData.append('image', userData.image);
      }

      const response = await fetch(`http://localhost:8000/api/user/update/${userId}`, {
        method: 'PUT',
        body: formData,
      });

      const data: UpdateUserResponse = await response.json();

      if (!response.ok) {
        throw new Error(data.error || 'Failed to update user');
      }

      return data;
    } catch (err) {
      const error = err as Error;
      setError(error.message);
      throw error;
    } finally {
      setLoading(false);
    }
  };

  return { updateUser, loading, error };
};