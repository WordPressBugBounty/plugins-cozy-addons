import { __ } from "@wordpress/i18n";

import {
	SelectControl,
	__experimentalUnitControl as UnitControl,
	__experimentalToggleGroupControl as ToggleGroupControl,
	__experimentalToggleGroupControlOptionIcon as ToggleGroupControlIcon,
	BaseControl,
} from "@wordpress/components";
import {
	lineSolid,
	formatUppercase,
	formatLowercase,
	formatCapitalize,
	formatUnderline,
	formatStrikethrough,
} from "@wordpress/icons";

import { memo } from "@wordpress/element";
import { useSelect } from "@wordpress/data";

import { get, set, cloneDeep } from "lodash";

import { getFontOptions, fontWeights } from "./utility.js";
import { ResponsiveIcons } from "./ResponsiveIcons.js";

export const TypographyControl = memo(
	({ attributes, setAttributes, path, googleFonts }) => {
		const typography = get(attributes, path);

		const fonts = getFontOptions(googleFonts);

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
				<SelectControl
					label={__("Font Family", "cozy-addons")}
					options={fonts}
					value={typography?.font?.family}
					onChange={(newValue) =>
						onChange({
							...typography,
							font: {
								...typography.font,
								family: newValue,
							},
						})
					}
					__next40pxDefaultSize
				/>

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
								{__("Font Size", "cozy-addons")}
							</BaseControl.VisualLabel>
							<ResponsiveIcons />
						</div>

						{editorDeviceType === "Desktop" && (
							<UnitControl
								label=""
								value={typography?.desktop?.font?.size}
								onChange={(newValue) =>
									onChange({
										...typography,
										desktop: {
											...typography?.desktop,
											font: {
												...typography?.desktop?.font,
												size: newValue,
											},
										},
									})
								}
								__next40pxDefaultSize
							/>
						)}

						{editorDeviceType === "Tablet" && (
							<UnitControl
								label=""
								value={typography?.tablet?.font?.size}
								onChange={(newValue) =>
									onChange({
										...typography,
										tablet: {
											...typography?.tablet,
											font: {
												...typography?.tablet?.font,
												size: newValue,
											},
										},
									})
								}
								__next40pxDefaultSize
							/>
						)}

						{editorDeviceType === "Mobile" && (
							<UnitControl
								label=""
								value={typography?.mobile?.font?.size}
								onChange={(newValue) =>
									onChange({
										...typography,
										mobile: {
											...typography?.mobile,
											font: {
												...typography?.mobile?.font,
												size: newValue,
											},
										},
									})
								}
								__next40pxDefaultSize
							/>
						)}
					</BaseControl>

					<SelectControl
						label={__("Font Weight", "cozy-addons")}
						options={fontWeights}
						value={typography?.font?.weight}
						onChange={(newValue) =>
							onChange({
								...typography,
								font: {
									...typography.font,
									weight: newValue,
								},
							})
						}
						__next40pxDefaultSize
					/>
				</div>

				<ToggleGroupControl
					label={__("Letter Case", "cozy-addons")}
					value={typography?.letterCase}
					onChange={(newValue) =>
						onChange({
							...typography,
							letterCase: newValue,
						})
					}
				>
					<ToggleGroupControlIcon
						label={__("None", "cozy-addons")}
						icon={lineSolid}
						value="none"
					/>
					<ToggleGroupControlIcon
						label={__("Uppercase", "cozy-addons")}
						icon={formatUppercase}
						value="uppercase"
					/>
					<ToggleGroupControlIcon
						label={__("Lowercase", "cozy-addons")}
						icon={formatLowercase}
						value="lowercase"
					/>
					<ToggleGroupControlIcon
						label={__("Capitalize", "cozy-addons")}
						icon={formatCapitalize}
						value="capitalize"
					/>
				</ToggleGroupControl>

				<ToggleGroupControl
					label={__("Decoration", "cozy-addons")}
					value={typography?.decoration}
					onChange={(newValue) =>
						onChange({
							...typography,
							decoration: newValue,
						})
					}
				>
					<ToggleGroupControlIcon
						label={__("None", "cozy-addons")}
						icon={lineSolid}
						value="none"
					/>
					<ToggleGroupControlIcon
						label={__("Underline", "cozy-addons")}
						icon={formatUnderline}
						value="underline"
					/>
					<ToggleGroupControlIcon
						label={__("Strikethrough", "cozy-addons")}
						icon={formatStrikethrough}
						value="line-through"
					/>
				</ToggleGroupControl>

				<div
					className="cozy-block-styles__div-separator"
					style={{ marginBottom: "22px" }}
				>
					<UnitControl
						label={__("Line Height", "cozy-addons")}
						value={typography?.lineHeight}
						onChange={(newValue) =>
							onChange({
								...typography,
								lineHeight: newValue,
							})
						}
					/>

					<UnitControl
						label={__("Letter Spacing", "cozy-addons")}
						value={typography?.letterSpacing}
						onChange={(newValue) =>
							onChange({
								...typography,
								letterSpacing: newValue,
							})
						}
					/>
				</div>
			</>
		);
	},
);
