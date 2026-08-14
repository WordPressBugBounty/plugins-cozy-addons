import { __ } from "@wordpress/i18n";

import { get, set, cloneDeep } from "lodash";

import { TextControl, Modal, Button } from "@wordpress/components";
import { update, reset } from "@wordpress/icons";

import { memo, useState } from "@wordpress/element";

const IconPicker = memo(({ icon, onChange, icons }) => {
	const [openModal, setOpenModal] = useState(false);

	const [searchQuery, setSearchQuery] = useState("");

	const handleSearch = (newValue) => {
		setSearchQuery(newValue);
	};

	const filteredIcons = Object.keys(icons).filter((key) =>
		key.toLowerCase().includes(searchQuery.toLowerCase()),
	);

	const handleIconClick = (dAttributeValue, viewBoxAttrVal) => {
		// Update the 'iconPath' and 'iconViewBox' attributes using setAttributes
		const [vx, vy, vw, vh] = viewBoxAttrVal.split(" ");
		onChange({
			...icon,
			path: dAttributeValue,
			viewBox: { vx, vy, vw, vh },
		});

		setOpenModal(false);
	};

	return (
		<>
			{String(icon.path).length <= 0 && (
				<div style={{ marginBottom: "22px" }}>
					<Button
						variant="secondary"
						text={__("Choose an Icon", "cozy-addons")}
						onClick={() => setOpenModal(true)}
					/>
				</div>
			)}
			{String(icon.path).length > 0 && (
				<>
					<svg
						width={26}
						height={26}
						viewBox={`${icon.viewBox.vx} ${icon.viewBox.vy} ${icon.viewBox.vw} ${icon.viewBox.vh}`}
						fill="black"
					>
						<path d={icon.path} />
					</svg>

					<div
						className="cozy-block-styles__div-separator"
						style={{ margin: "6px 0 22px" }}
					>
						<div>
							<Button
								text={__("Update Icon", "cozy-addons")}
								variant="secondary"
								icon={update}
								onClick={() => setOpenModal(true)}
							/>
						</div>

						<div>
							<Button
								text={__("Reset", "cozy-addons")}
								variant="unstyled"
								icon={reset}
								onClick={() =>
									onChange({
										...icon,
										path: "",
										viewBox: {
											vx: "",
											vy: "",
											vw: "",
											vh: "",
										},
									})
								}
							/>
						</div>
					</div>
				</>
			)}

			{openModal && (
				<Modal
					title={__("Cozy Icon Library", "cozy-addons")}
					onRequestClose={() => setOpenModal(false)}
					size="large"
					isFullScreen={true}
				>
					<div style={{ maxWidth: "320px", marginBottom: "22px" }}>
						<TextControl
							type="text"
							placeholder={__("Search Icons...", "cozy-addons")}
							value={searchQuery}
							onChange={(newValue) => handleSearch(newValue)}
						/>
					</div>

					<div className="cozy-modal__icons-holder">
						{filteredIcons.map((key) => {
							const value = icons[key];

							// Regex pattern to match the value of the d attribute
							const regex = /d="([^"]+)"/;
							const match = value.match(regex);

							// Regular expression to match the viewBox attribute
							const viewBoxRegex = /viewBox\s*=\s*"([^"]*)"/;
							const viewBoxMatch = value.match(viewBoxRegex);

							// Extract the value of the d attribute
							const dAttributeValue = match ? match[1] : "";
							const viewBoxAttrVal = viewBoxMatch ? viewBoxMatch[1] : "";

							return (
								<Button
									key={key}
									onClick={() =>
										handleIconClick(dAttributeValue, viewBoxAttrVal)
									}
								>
									<i dangerouslySetInnerHTML={{ __html: value }} />
									<p>{key}</p>
								</Button>
							);
						})}
					</div>
				</Modal>
			)}
		</>
	);
});

// Wrapper for call sites that prefer path-based access
export const IconPickerAtPath = ({
	attributes,
	setAttributes,
	path,
	icons,
}) => {
	const icon = get(attributes, path);
	const onChange = (newIcon) => {
		const next = cloneDeep(attributes);
		set(next, path, newIcon);
		setAttributes(next);
	};
	return <IconPicker icons={icons} icon={icon} onChange={onChange} />;
};
