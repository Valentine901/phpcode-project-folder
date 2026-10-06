import { Routes, Route } from "react-router-dom";
import Register from "./pages/Register";
import Login from "./pages/Signin";
import Home from "./pages/Home";
import CreateProfile from "./pages/CreateProfile";
import ProtectedRoute from "./components/ProtectedRoute";

const App = () => {
  return (
    <Routes>
      <Route path="/" element={
        <ProtectedRoute>
          <Home />
        </ProtectedRoute>
      } />
      <Route path="/create-profile" element={
        <ProtectedRoute>
          <CreateProfile />
        </ProtectedRoute>
      } />
      <Route path="/auth/signup" element={<Register />} />
      <Route path="/auth/signin" element={<Login />} />
    </Routes>
  )
}

export default App;