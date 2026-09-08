import { __ } from "@wordpress/i18n";

import {
	__experimentalUnitControl as UnitControl,
	BaseControl,
} from "@wordpress/components";

import { memo } from "@wordpress/element";
import { useSelect } from "@wordpress/data";

import { get, set, cloneDeep } from "lodash";

import { ResponsiveIcons } from "./ResponsiveIcons.js";

export const DimensionControl = memo(
	({ attributes, setAttributes, path }) => {
		const dimension = get(attributes, path);

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
				<div
					className="cozy-block-styles__div-separator"
					style={{ margin: "22px 0" }}
				>
					<BaseControl>
						<div
							style={{
								display: "flex",
								alignItems: "center",
								gap: "2px",
							}}
						>
							<BaseControl.VisualLabel style={{ marginBottom: "0" }}>
								{__("Width", "cozy-addons")}
							</BaseControl.VisualLabel>
							<ResponsiveIcons />
						</div>

						{editorDeviceType === "Desktop" && (
							<>
								<UnitControl
									label=""
									value={dimension?.desktop?.width}
									onChange={(newValue) =>
										onChange({
											...dimension,
											desktop: {
												...dimension?.desktop,
												width: newValue,
											},
										})
									}
								/>
							</>
						)}
						{editorDeviceType === "Tablet" && (
							<>
								<UnitControl
									label=""
									value={dimension?.tablet?.width}
									onChange={(newValue) =>
										onChange({
											...dimension,
											tablet: {
												...dimension?.tablet,
												width: newValue,
											},
										})
									}
								/>
							</>
						)}
						{editorDeviceType === "Mobile" && (
							<>
								<UnitControl
									label=""
									value={dimension?.mobile?.width}
									onChange={(newValue) =>
										onChange({
											...dimension,
											mobile: {
												...dimension?.mobile,
												width: newValue,
											},
										})
									}
								/>
							</>
						)}
					</BaseControl>

					<BaseControl>
						<div
							style={{
								display: "flex",
								alignItems: "center",
								gap: "2px",
							}}
						>
							<BaseControl.VisualLabel style={{ marginBottom: "0" }}>
								{__("Height", "cozy-addons")}
							</BaseControl.VisualLabel>
							<ResponsiveIcons />
						</div>

						{editorDeviceType === "Desktop" && (
							<>
								<UnitControl
									label=""
									value={dimension?.desktop?.height}
									onChange={(newValue) =>
										onChange({
											...dimension,
											desktop: {
												...dimension?.desktop,
												height: newValue,
											},
										})
									}
								/>
							</>
						)}
						{editorDeviceType === "Tablet" && (
							<>
								<UnitControl
									label=""
									value={dimension?.tablet?.height}
									onChange={(newValue) =>
										onChange({
											...dimension,
											tablet: {
												...dimension?.tablet,
												height: newValue,
											},
										})
									}
								/>
							</>
						)}
						{editorDeviceType === "Mobile" && (
							<>
								<UnitControl
									label=""
									value={dimension?.mobile?.height}
									onChange={(newValue) =>
										onChange({
											...dimension,
											mobile: {
												...dimension?.mobile,
												height: newValue,
											},
										})
									}
								/>
							</>
						)}
					</BaseControl>
				</div>
			</>
		);
	},
);
