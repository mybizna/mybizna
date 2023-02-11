// astexplorer: https://astexplorer.net/
// babel-core doc: https://babeljs.io/docs/en/babel-core

/**
import {
	traverse,
	transformFromAstAsync as babel_transformFromAstAsync,
	types as t,
} from '@babel/core';

import {
	parse as babel_parse,
} from '@babel/parser';


import {
	codeFrameColumns,
} from '@babel/code-frame';


// @ts-ignore (Could not find a declaration file for module '@babel/plugin-transform-modules-commonjs')
import babelPluginTransformModulesCommonjs from '@babel/plugin-transform-modules-commonjs'
 */

import * as SparkMD5 from 'spark-md5'

import { createSFCModule } from '@/vue3-sfc-loader/createVue3SFCModule'


/**
 * @internal
 */
/**
const genSourcemap = !!process.env.GEN_SOURCEMAP;
 */
const version = '0.8.4';


// tools
/**
 * @internal
 */
export function formatError(message, path, source) {
	return path + '\n' + message;
}


/**
 * @internal
 */


export function formatErrorLineColumn(message, path, source, line, column) {
	if (!line) {
		return formatError(message, path, source)
	}

	const location = {
		start: { line, column },
	};

	return formatError(message, path, source)
	//return formatError(codeFrameColumns(source, location, { message }), path, source)
}
 

/**
 * @internal
 */


export function formatErrorStartEnd(message, path, source, start, end) {
	if (!start) {
		return formatError(message, path, source)
	}

	const location = {
		start: { line: 1, column: start }
	};
	if (end) {
		location.end = { line: 1, column: end }
	}
	return formatError(message, path, source)
	//return formatError(codeFrameColumns(source, location, { message }), path, source)
}
 

/**
 * @internal
 */
export function hash(...valueList) {

	return valueList.reduce((hashInstance, val) => hashInstance.append(String(val)), new SparkMD5()).end().slice(0, 8);
}



/**
 * Simple cache helper
 * preventCache usage: non-fatal error
 * @internal
 */
export async function withCache(cacheInstance, key, valueFactory) {

	let cachePrevented = false;

	const api = {
		preventCache: () => cachePrevented = true,
	}

	if (!cacheInstance)
		return await valueFactory(api);

	const hashedKey = hash(...key);
	const valueStr = await cacheInstance.get(hashedKey);
	if (valueStr)
		return JSON.parse(valueStr);

	const value = await valueFactory(api);

	if (!cachePrevented)
		await cacheInstance.set(hashedKey, JSON.stringify(value));

	return value;
}

/**
 * @internal
 */
export class Loading {

	constructor(promise) {

		this.promise = promise;
	}
}



/**
 * @internal
 */
export function interopRequireDefault(obj) {

	return obj && obj.__esModule ? obj : { default: obj };
}

// node types: https://babeljs.io/docs/en/babel-types
// handbook: https://github.com/jamiebuilds/babel-handbook/blob/master/translations/en/plugin-handbook.md

/**
 * import is a reserved keyword, then rename
 * @internal
 */
/**
export function renameDynamicImport(fileAst) {

	traverse(fileAst, {
		CallExpression(path) {

			if (t.isImport(path.node.callee))
				path.replaceWith(t.callExpression(t.identifier('import__'), path.node.arguments))
		}
	});
}
 */

/**
 * @internal
 */
/**
export function parseDeps(fileAst) {

	const requireList = [];

	traverse(fileAst, {
		ImportDeclaration(path) {

			requireList.push(path.node.source.value);
		},
		CallExpression(path) {

			if (
				// @ts-ignore (Property 'name' does not exist on type 'ArrayExpression')
				path.node.callee.name === 'require'
				&& path.node.arguments.length === 1
				&& t.isStringLiteral(path.node.arguments[0])
			) {

				requireList.push(path.node.arguments[0].value)
			}
		}
	});

	return requireList;
}
*/



/**
 * @internal
 */
/**
export async function transformJSCode(source, moduleSourceType, filename, additionalBabelParserPlugins, additionalBabelPlugins, log) {

	let ast;
	try {

		ast = babel_parse(source, {
			// doc: https://babeljs.io/docs/en/babel-parser#options
			sourceType: moduleSourceType ? 'module' : 'script',
			sourceFilename: filename.toString(),
			plugins: [
				//				'optionalChaining',
				//				'nullishCoalescingOperator',
				...additionalBabelParserPlugins !== undefined ? additionalBabelParserPlugins : [],
			],
		});
	} catch (ex) {

		log?.('error', 'parse script', formatErrorLineColumn(ex.message, filename.toString(), source, ex.loc.line, ex.loc.column + 1));
		throw ex;
	}

	renameDynamicImport(ast);
	const depsList = parseDeps(ast);

	const transformedScript = await babel_transformFromAstAsync(ast, source, {
		sourceMaps: genSourcemap, // doc: https://babeljs.io/docs/en/options#sourcemaps
		plugins: [ // https://babeljs.io/docs/en/options#plugins
			...moduleSourceType ? [babelPluginTransformModulesCommonjs] : [], // https://babeljs.io/docs/en/babel-plugin-transform-modules-commonjs#options
			// @ts-ignore
			...additionalBabelPlugins !== undefined ? Object.values(additionalBabelPlugins) : [],
		],
		babelrc: false,
		configFile: false,
		highlightCode: false,
		compact: true, // doc: All optional newlines and whitespace will be omitted when generating code in compact mode.
		comments: false,
	});

	return [depsList, transformedScript.code];
}
*/


// module tools


export async function loadModuleInternal(pathCx, options) {

	const { moduleCache, loadModule, handleModule } = options;

	const { id, path, getContent } = options.getResource(pathCx, options);

	if (id in moduleCache) {

		if (moduleCache[id] instanceof Loading)
			return moduleCache[id];
		else
			return moduleCache[id];
	}


	moduleCache[id] = new Loading((async () => {

		if (loadModule) {

			const module = await loadModule(id, options);
			if (module !== undefined)
				return moduleCache[id] = module;
		}
		
		const { getContentData, type } = await getContent();
		console.log('getContentData');
		console.log(getContentData);

		// note: null module is accepted
		let module = undefined;

		if (handleModule !== undefined)
			module = await handleModule(type, getContentData, path, options);

		console.log('handleModule');
		console.log(handleModule);

		if (module === undefined)
			module = await defaultHandleModule(type, getContentData, path, options);

		console.log('module');
		console.log(module);	

		if (module === undefined)
			throw new TypeError(`Unable to handle ${type} files (${path})`);

		return moduleCache[id] = module;

	})());

	return await (moduleCache[id]).promise;
}




/**
 * Create a cjs module
 * @internal
 */
export function createCJSModule(refPath, source, options) {

	const { moduleCache, pathResolve, getResource } = options;

	const require = function (relPath) {

		const { id } = getResource({ refPath, relPath }, options);
		if (id in moduleCache)
			return moduleCache[id];

		throw new Error(`require(${JSON.stringify(id)}) failed. module not found in moduleCache`);
	}

	const importFunction = async function (relPath) {

		return await loadModuleInternal({ refPath, relPath }, options);
	}

	const module = {
		exports: {}
	}

	// see https://github.com/nodejs/node/blob/a46b21f556a83e43965897088778ddc7d46019ae/lib/internal/modules/cjs/loader.js#L195-L198
	// see https://github.com/nodejs/node/blob/a46b21f556a83e43965897088778ddc7d46019ae/lib/internal/modules/cjs/loader.js#L1102
	Function('exports', 'require', 'module', '__filename', '__dirname', 'import__', source).call(module.exports, module.exports, require, module, refPath, pathResolve({ refPath, relPath: '.' }), importFunction);

	return module;
}


/**
 * @internal
 */

/**
export async function createJSModule(source, moduleSourceType, filename, options) {

	const { compiledCache, additionalBabelParserPlugins, additionalBabelPlugins, log } = options;

	const [depsList, transformedSource] = await withCache(compiledCache, [version, source, filename], async () => {

		return await transformJSCode(source, moduleSourceType, filename, additionalBabelParserPlugins, additionalBabelPlugins, log);
	});

	await loadDeps(filename, depsList, options);
	return createCJSModule(filename, transformedSource, options).exports;
}
 */

/**
 * Just load and cache given dependencies.
 * @internal
 */
export async function loadDeps(refPath, deps, options){

	await Promise.all(deps.map(relPath => loadModuleInternal({ refPath, relPath }, options)))
}


/**
 * Default implementation of handleModule
 */
async function defaultHandleModule(type, getContentData, path, options) {

	switch (type) {
		case '.vue': return createSFCModule((await getContentData(false)) , path, options);
		//case '.js': return createJSModule((await getContentData(false)) , false, path, options);
		//case '.mjs': return createJSModule((await getContentData(false)) , true, path, options);
	}

	return undefined;
}
