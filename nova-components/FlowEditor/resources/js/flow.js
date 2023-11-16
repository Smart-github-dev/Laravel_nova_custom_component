import App from "./pages/App";
// import "../css/flowy.css";

Nova.booting((app, store) => {
    Nova.inertia("FlowEditor", App);
});
