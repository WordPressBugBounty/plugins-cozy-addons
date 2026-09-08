import { __ } from "@wordpress/i18n";

import { BoxControl, BaseControl } from "@wordpress/components";

import { memo } from "@wordpress/element";
import { useSelect } from "@wordpress/data";

import { get, set, cloneDeep } from "lodash";

import { ResponsiveIcons } from "./ResponsiveIcons.js";

export const PaddingControl = memo(({ attributes, setAttributes, path }) => {
	const elAttr = get(attributes, path);

	const onChange = (newValue) => {
		const next = cloneDeep(attributes);
		set(next, path, newValue);
		setAttributes(next);
	};

	// Get current editor preview device
	const editorDeviceType = useSelect((select) =>
		select("core/editor").getDeviceType(),
	);

	return (
		<>
			<BaseControl className="cozy-box-control">
				<div
					style={{
						display: "inline-flex",
						alignItems: "center",
						gap: "2px",
						position: "relative",
						zIndex: "2",
					}}
				>
					<BaseControl.VisualLabel style={{ marginBottom: "0" }}>
						{__("Padding", "cozy-addons")}
					</BaseControl.VisualLabel>
					<ResponsiveIcons />
				</div>

				{editorDeviceType === "Desktop" && (
					<BoxControl
						label=""
						resetValues={[
							{
								top: "0px",
								right: "0px",
								bottom: "0px",
								left: "0px",
							},
						]}
						values={elAttr?.desktop?.padding}
						onChange={(newValue) =>
							onChange({
								...elAttr,
								desktop: {
									...elAttr?.desktop,
									padding: newValue,
								},
							})
						}
						__next40pxDefaultSize
					/>
				)}
				{editorDeviceType === "Tablet" && (
					<BoxControl
						label=""
						resetValues={[
							{
								top: "0px",
								right: "0px",
								bottom: "0px",
								left: "0px",
							},
						]}
						values={elAttr?.tablet?.padding}
						onChange={(newValue) =>
							onChange({
								...elAttr,
								tablet: {
									...elAttr?.tablet,
									padding: newValue,
								},
							})
						}
						__next40pxDefaultSize
					/>
				)}
				{editorDeviceType === "Mobile" && (
					<BoxControl
						label=""
						resetValues={[
							{
								top: "0px",
								right: "0px",
								bottom: "0px",
								left: "0px",
							},
						]}
						values={elAttr?.mobile?.padding}
						onChange={(newValue) =>
							onChange({
								...elAttr,
								mobile: {
									...elAttr?.mobile,
									padding: newValue,
								},
							})
						}
						__next40pxDefaultSize
					/>
				)}
			</BaseControl>
		</>
	);
});
