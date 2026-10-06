import { useState, useEffect } from "react"
import { API } from "../constants/API"
import { Mail, Lock, LogIn } from "lucide-react";
import { useNavigate } from "react-router-dom";
import { useAuth } from "../context/AuthContext";

const Login = () => {
   
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [error, setError] = useState("");
    const [success, setSuccess] = useState("");
    const [loading, setLoading] = useState(false);
    const { GetCurrentUser, fetchProfile } = useAuth();

    const navigate = useNavigate();

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        setError("");
        setSuccess("");

        try {
            await API.post("/auth/login.php", {
                email: email,
                password: password
            })
            await GetCurrentUser()
            await fetchProfile();
            setEmail("");
            setPassword("");
            setError("");
            setSuccess("Authenticated successfully.");
            navigate("/");
            
        } catch (error) {
            if (error.response) {
                setError(error.response.data.message);
            } else if (error.request) {
                setError("Unable to connect to the server");
            } else {
                setError("Something went wrong");
            }
        } finally {
            setLoading(false);
        }
    }

    // message disappear logic 
    useEffect(() => {
        const timer = setTimeout(() => {
            if(error || success) {
                setError("");
                setSuccess("");
            }
        }, 3000)
        return () => clearTimeout(timer);
    }, [success, error])

    return (
        <div className="bg-gray-100/80 w-full min-h-screen flex justify-center pt-20">



            <form onSubmit={handleSubmit} className="bg-gray-300/30 p-6 rounded-lg max-w-xl w-full space-y-5 h-full">

                <div className="flex text-gray-100 h-20 w-20 bg-black rounded-full items-center justify-center mx-auto">
                    <LogIn size={32} />
                </div>

               {error && <div className="flex text-red-500/70 py-3 w-full border-0.8 border-red-300 bg-red-200/20 rounded-lg items-center justify-center mx-auto text-lg font-semibold">
                    <span>{error}</span>
                </div> }

               {success && <div className="flex text-green-500/70 p-3 w-full border-0.8 border-green-300 bg-green-200/20 rounded-lg items-center justify-center mx-auto text-lg font-semibold">
                    <span>{success}</span>
                </div> }

                <div className="flex flex-col gap-1">
                    <label
                        className="text-lg font-semibold text-gray-600/80"
                        htmlFor="email">Email Address*</label>
                    <div className="flex items-center pl-3 rounded-md w-full bg-gray-100 ring-offset-2 focus-within:ring-2 focus-within:ring-gray-600 focus-within:ring-offset-2 text-gray-500">
                        <Mail size={20} />
                        <input
                            className="bg-transparent border-none outline-none p-3 w-full focus:ring-0 text-lg text-gray-800 font-semibold"
                            required type="email"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)} />
                    </div>
                </div>
                <div className="flex flex-col gap-1">
                    <label
                        className="text-lg font-semibold text-gray-600/80"
                        htmlFor="password">Password*</label>
                    <div className="flex items-center pl-3 rounded-md w-full bg-gray-100 ring-offset-2 focus-within:ring-2 focus-within:ring-gray-600 focus-within:ring-offset-2 text-gray-500">
                        <Lock size={20} />
                        <input
                            className="bg-transparent border-none outline-none p-3 w-full focus:ring-0 font-semibold text-black"
                            required type="password"
                            value={password}
                            onChange={(e) => setPassword(e.target.value)} placeholder="••••••••" />
                    </div>
                </div>

                <div className="w-full mx-auto flex justify-center">
                    <button disabled={loading} className="py-4 bg-black hover:bg-black/80 text-gray-100 text-lg font-semibold w-50 rounded-lg transition-all duration-300">
                    {loading ? "Signing..." : "Sign In"}
                    </button>
                </div>

                <div className="flex gap-4 text-md font-semibold text-gray-600/80">
                    <span>Don't have an account?</span>
                    <a href="/auth/signup" className="text-lg text-black hover:underline">Sign Up</a>
                </div>
            </form>
        </div>
    )
}

export default Login

