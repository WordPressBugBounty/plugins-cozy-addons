import { __ } from "@wordpress/i18n";

export const PremiumLink = () => {
	return (
		<>
			<div
				style={{
					display: "flex",
					flexDirection: "column",
					justifyContent: "center",
					alignItems: "center",
					padding: "16px",
					marginBottom: "10px",
				}}
			>
				<p>
					<svg
						width="45"
						height="45"
						viewBox="0 0 45 45"
						fill="none"
						xmlns="http://www.w3.org/2000/svg"
					>
						<rect width="45" height="45" rx="22.5" fill="#5253F9" />
						<path
							d="M10.0781 21.5193C10.0781 15.2016 15.1996 10.0801 21.5173 10.0801V21.5193H10.0781Z"
							fill="white"
						/>
						<path
							d="M10.0781 23.3191H21.5173V34.7583C15.1996 34.7583 10.0781 29.6368 10.0781 23.3191Z"
							fill="white"
						/>
						<path
							d="M23.3203 10.0801H29.0399C32.1988 10.0801 34.7595 12.6408 34.7595 15.7997C34.7595 18.9585 32.1988 21.5193 29.0399 21.5193H23.3203V10.0801Z"
							fill="white"
						/>
						<path
							d="M23.3203 23.3191H29.0399C32.1988 23.3191 34.7595 25.8799 34.7595 29.0387C34.7595 32.1976 32.1988 34.7583 29.0399 34.7583H23.3203V23.3191Z"
							fill="white"
						/>
					</svg>
				</p>
				<h2
					style={{
						fontSize: "18px",
						fontFamily: "Inter",
						marginTop: "-5px",
						marginBottom: "15px",
					}}
				>
					{__("Access Without Limits!", "cozy-addons")}
				</h2>
				<p style={{ textAlign: "center", lineHeight: "20px" }}>
					{__(
						"Access more blocks and advanced features for effortless design. Upgrade today for a richer web-building experience!",
						"cozy-addons",
					)}
				</p>
				<a href="https://cozythemes.com/pricing-and-plans/" target="_blank">
					<button
						className="cozy-block-premium-button"
						style={{
							backgroundColor: "#0c50ff",
							borderRadius: "20px",
							padding: "10px 22px",
							border: "none",
							color: "#fff",
							fontSize: "11px",
							fontWeight: "500",
							cursor: "pointer",
						}}
					>
						<div
							style={{
								display: "flex",
								gap: "5px",
								margin: "0",
							}}
						>
							<div>
								<svg
									width="10"
									height="10"
									viewBox="0 0 10 10"
									fill="none"
									xmlns="http://www.w3.org/2000/svg"
								>
									<path
										d="M9.29768 0.0630875L0.24397 5.2847C-0.109583 5.48778 -0.0646564 5.97987 0.286944 6.12828L2.36334 6.99919L7.97527 2.05487C8.0827 1.95919 8.23506 2.10565 8.14325 2.21695L3.43767 7.94822V9.52017C3.43767 9.98102 3.99437 10.1626 4.26784 9.8287L5.50821 8.31924L7.94206 9.33857C8.21943 9.45573 8.53588 9.28194 8.58666 8.98317L9.99306 0.547365C10.0595 0.152913 9.6356 -0.132186 9.29768 0.0630875Z"
										fill="white"
									/>
								</svg>
							</div>
							<div>{__("Upgrade to Pro", "cozy-addons")}</div>
						</div>
					</button>
				</a>
			</div>
		</>
	);
};
