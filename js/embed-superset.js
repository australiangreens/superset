async function fetchGuestToken () {
  const guestTokenResult = await CRM.api4("SupersetDashboard", "guestToken");
  return guestTokenResult[0].guest_token;
}

window.onload = () => {
  const { SUPERSET_BASE_URL } = CRM.vars.superset;

  const dashboardPopup = document.querySelector("div#superset_dashboard_popup dialog");
  dashboardPopup.querySelector("button#close_popup").onclick = () => dashboardPopup.close();

  CRM.$("a.superset-dashboard-link").click(async (event) => {
    event.preventDefault();

    const embedID = event.target.getAttribute("data-dashboard-embed-id");
    const title = event.target.getAttribute("data-dashboard-title");

    dashboardPopup.querySelector("h1").textContent = title;
    dashboardPopup.showModal();

    supersetEmbeddedSdk.embedDashboard({
      dashboardUiConfig: {
        filters: { expanded: false },
        hideTitle: true,
      },
      fetchGuestToken: () => fetchGuestToken(),
      id: embedID,
      mountPoint: document.querySelector("div#superset_dashboard_popup dialog #popup_content"),
      supersetDomain: SUPERSET_BASE_URL,
    });
  });
};
